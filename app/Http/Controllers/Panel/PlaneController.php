<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Plane;
use App\Http\Requests\PlaneStoreUpdateFormRequest;

class PlaneController extends Controller
{
    private $plane;
    protected $totalPage = 20;

    public function __construct(Plane $plane)
    {
        $this->plane = $plane;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $title = 'Listagem dos Aviões';

        $planes = $this->plane->with('brand')->paginate($this->totalPage);
        
        return view('panel.planes.index', compact('title', 'planes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Cadastrar Avião';

        $brands = Brand::pluck('name', 'id');

        $classes = $this->plane->classes();
        
        return view('panel.planes.create-edit', compact('title', 'brands', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlaneStoreUpdateFormRequest $request)
    {
        $dataForm = $request->all();

        $insert = $this->plane->create($dataForm);

        if($insert)
            return redirect()
                ->route('planes.index')
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
        $plane = $this->plane->with('brand')->find($id);

        if(!$plane)
            return redirect()->back();

        $title = "Detalhes do Avião: {$plane->id}";

        $brand = $plane->brand->name;
    
        return view('panel.planes.show', compact('title', 'plane', 'brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plane = $this->plane->find($id);
        if(!$plane)
            return redirect()
            ->back();
        
        $title = "Editar Avião: {$plane->id} ";

        $brands = Brand::pluck('name', 'id');

        $classes = $this->plane->classes();
        
        return view('panel.planes.create-edit', compact('title', 'brands', 'classes', 'plane'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlaneStoreUpdateFormRequest $request, $id)
    {
        $plane = $this->plane->find($id);

        if(!$plane)
            return redirect()->back();

        $update = $plane->update($request->all());
        
        if($update)
            return redirect()
                ->route('planes.index')
                ->with('success', 'Cadastro alterado com sucesso !');
        else 
            return redirect()
                ->back()
                ->with('error', 'Falha ao alterar !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plane = $this->plane->find($id);

        if(!$plane)
            return redirect()->back();

        $delete = $plane->delete();

        if($delete)
            return redirect()
                ->route('planes.index')
                ->with('success', 'Cadastro excluído com sucesso !');
        else 
            return redirect()
                ->back()
                ->with('error', 'Falha ao excluir !');
    }

    public function search(Request $request)
    {
        $dataForm = $request->except('token');

        $planes = $this->plane->search($request->key_search, $this->totalPage);
        
        $title = "Planes, filtros para: {$request->key_search}";

        return view('panel.planes.index', compact('title', 'planes', 'dataForm'));
    }
}
