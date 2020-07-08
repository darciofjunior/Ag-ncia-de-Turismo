<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\City;
use App\Http\Requests\AirportStoreUpdateFormRequest;

class AirportController extends Controller
{
    private $airport, $city;
    protected $totalPage = 20;

    public function __construct(City $city, Airport $airport) 
    {
        $this->city     = $city;
        $this->airport  = $airport;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idCity)
    {
        $city = $this->city->find($idCity);
        if(!$city)
            return redirect()->back();

        $title  = "Aeroportos da cidade {$city->name}";

        $airports = $city->airports()->paginate($this->totalPage);

        return view('panel.airports.index', compact('city', 'title', 'airports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idCity)
    {
        $city = $this->city->find($idCity);
        if(!$city)
            return redirect()->back();

        $title  = "Cadastrar Aeroporto na cidade {$city->name}";

        return view('panel.airports.create-edit', compact('city', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirportStoreUpdateFormRequest $request, $idCity)
    {
        $city = $this->city->find($idCity);
        if(!$city)
            return redirect()->back();

        if($city->airports()->create($request->all()))
            return redirect()
                ->route('airports.index', $idCity)
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
    public function show($idCity, $id)
    {
        $airport = $this->airport->with('city')->find($id);
        if(!$airport)
            return redirect()->back();

        $city = $airport->city;

        $title  = "Detalhes do Aeroporto {$airport->name} - {$city->name} ";

        return view('panel.airports.show', compact('airport', 'city', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idCity, $id)
    {
        $airport = $this->airport->with('city')->find($id);
        if(!$airport)
            return redirect()->back();

        $city = $airport->city;

        $title  = "Editar Aeroporto {$airport->name}";

        return view('panel.airports.create-edit', compact('airport', 'city', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AirportStoreUpdateFormRequest $request, $idCity, $id)
    {
        $airport = $this->airport->with('city')->find($id);
        if(!$airport)
            return redirect()->back();

        if($airport->update($request->all()))
            return redirect()
                ->route('airports.index', $idCity)
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
    public function destroy($idCity, $id)
    {
        $airport = $this->airport->find($id);
        if(!$airport)
            return redirect()->back();

        if($airport->delete())
            return redirect()
                ->route('airports.index', $idCity)
                ->with('success', 'Cadastro deletado com sucesso !');
        else 
            return redirect()
                ->back()
                ->with('error', 'Falha ao deletar !')
                ->withInput();
    }

    public function search($idCity, Request $request)
    {
        $city = $this->city->find($idCity);
        if(!$city)
            return redirect()->back();

        $airports   = $this->airport->search($city, $request, $this->totalPage);

        $title      = "Aeroportos da cidade {$city->name}";

        $dataForm   = $request->except('_token');

        return view('panel.airports.index', compact('city', 'title', 'airports', 'dataForm'));
    }
}
