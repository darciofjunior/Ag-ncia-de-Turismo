<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Reserve;
use App\Models\User;
use App\Http\Requests\ReserveStoreFormRequest;

class ReserveController extends Controller
{
    private $reserve;
    protected $totalPage = 50;

    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Reservas de passagens aéreas';

        $reserves = $this->reserve->with(['user', 'flight'])->paginate($this->totalPage);

        return view('panel.reserves.index', compact('title', 'reserves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title      = 'Nova Reserva';

        $users      = User::pluck('name', 'id');
        $flights    = Flight::pluck('id', 'id');
        $status     = $this->reserve->status();

        return view('panel.reserves.create-edit', compact('title', 'users', 'flights', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReserveStoreFormRequest $request)
    {
        if($this->reserve->create($request->all()))
            return redirect()
                ->route('reserves.index')
                ->with('success', 'Reserva realizada com sucesso !');

        return redirect()
            ->back()
            ->with('error', 'Falha ao reservar !')
            ->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reserve = $this->reserve->with(['user', 'flight'])->find($id);
        if(!$reserve)
            return redirect()
            ->back();
        
        $user   = $reserve->user;
        $flight = $reserve->flight;
        $status = $this->reserve->status();

        $title = "Editar Reserva do Usuário: {$user} ";
        
        return view('panel.reserves.create-edit', compact('reserve', 'user', 'flight', 'status', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reserve = $this->reserve->find($id);
        if(!$reserve)
            return redirect()
            ->back();

        if($reserve->update($request->all()))
            return redirect()
                ->route('reserves.index')
                ->with('success', 'Status alterado com sucesso !');

        return redirect()
            ->back()
            ->with('error', 'Falha ao alterar Status !')
            ->withInput();
    }

    public function search(Request $request)
    {
        $reserves    = $this->reserve->search($request, $this->totalPage);

        $dataForm   = $request->except('token');

        $title      = "Resultado pesquisado(s) ";

        return view('panel.reserves.search', compact('reserves', 'dataForm', 'title'));
    }
}
