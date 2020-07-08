<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Plane;
use App\Http\Requests\FlightStoreUpdateFormRequest;

class FlightController extends Controller
{
    private $flight;
    protected $totalPage = 20;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = 'Vôos Disponíveis';

        $flights    = $this->flight->getItems();

        $airports   = Airport::pluck('name', 'id');
        
        return view('panel.flights.index', compact('title', 'flights', 'airports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Vôo';

        $airports   = Airport::pluck('name', 'id');
        
        $planes     = Plane::pluck('id', 'id');
        
        return view('panel.flights.create-edit', compact('title', 'airports', 'planes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlightStoreUpdateFormRequest $request)
    {
        $newNameFile = '';

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            
            $nameFile       = uniqid(date('HisYmd'));
            $extension      = $request->image->extension();
            $newNameFile    = "{$nameFile}.{$extension}";

            if(!$request->image->storeAs('flights', $newNameFile))
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer Upload de Imagem !')
                    ->withInput();
        }

        $dataForm = $request->all();

        $dataForm['old_price']      = str_replace('.', '', $request->old_price);
        $dataForm['old_price']      = str_replace(',', '.', $request->old_price);
        $dataForm['price']          = str_replace('.', '', $request->price);
        $dataForm['price']          = str_replace(',', '.', $request->price);
        
        if(isset($dataForm['is_promotion'])) {
            $dataForm['is_promotion']   = $dataForm['is_promotion'] ? true : false;
        }else {
            $dataForm['is_promotion']   = false;
        }

        $dataForm['image']          = $newNameFile;

        if($this->flight->create($dataForm))
            return redirect()
                ->route('flights.index')
                ->with('success', 'Cadastro realizado com sucesso !');
        else 
            return redirect()
                ->back()
                ->with('error', 'Falha ao cadastrar !')
                ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flight = $this->flight->with(['origin', 'destination'])->find($id);

        if(!$flight)
            return redirect()->back();

        $title = "Detalhes do Vôo: {$flight->id}";

        return view('panel.flights.show', compact('title', 'flight'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flight = $this->flight->find($id);

        if(!$flight)
            return redirect()->back();

        $title = "Editar Vôo: {$flight->id}";

        $airports   = Airport::pluck('name', 'id');
        
        $planes     = Plane::pluck('id', 'id');
    
        return view('panel.flights.create-edit', compact('title', 'flight', 'airports', 'planes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FlightStoreUpdateFormRequest $request, $id)
    {
        $flight = $this->flight->find($id);

        if(!$flight)
            return redirect()->back();

        $newNameFile = $flight->image;

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            
            if(!$flight->image) {
                $nameFile       = uniqid(date('HisYmd'));
                $extension      = $request->image->extension();
                $newNameFile    = "{$nameFile}.{$extension}";
            }

            if(!$request->image->storeAs('flights', $newNameFile))
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer Upload de Imagem !')
                    ->withInput();
        }

        $dataForm = $request->all();

        $dataForm['old_price']      = str_replace('.', '', $request->old_price);
        $dataForm['old_price']      = str_replace(',', '.', $request->old_price);
        $dataForm['price']          = str_replace('.', '', $request->price);
        $dataForm['price']          = str_replace(',', '.', $request->price);

        if(isset($dataForm['is_promotion'])) {
            $dataForm['is_promotion']   = $dataForm['is_promotion'] ? true : false;
        }else {
            $dataForm['is_promotion']   = false;
        }
        
        $dataForm['image'] = $newNameFile;

        if($flight->update($dataForm))
            return redirect()
                ->route('flights.index')
                ->with('success', 'Cadastro alterado com sucesso !');
        else 
            return redirect()
                ->back()
                ->with('error', 'Falha ao alterar !')
                ->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$this->flight->find($id)->delete();

        return redirect()
                ->route('flights.index')
                ->with('success', 'Cadastro excluído com sucesso !');
    }

    public function search(Request $request)
    {
        $flights    = $this->flight->search($request, $this->totalPage);

        $dataForm   = $request->except('token');

        $title      = "Resultado dos vôo(s) pesquisado(s) ";

        $airports   = Airport::pluck('name', 'id');
        $airports->prepend('Escolha o aeroporto', '');


        return view('panel.flights.index', compact('title', 'flights', 'dataForm', 'airports'));
    }
}
