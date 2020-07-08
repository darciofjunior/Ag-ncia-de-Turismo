<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    private $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }

    public function index()
    {
        $title = 'Listagem dos Estados';

        $states = $this->state->get();
        
        return view('panel.states.index', compact('title', 'states'));
    }

    public function search(Request $request)
    {
        $dataForm = $request->all();

        $keySearch = $request->key_search;

        $states = $this->state->search($keySearch);

        $title = "States, filtros para: {$request->key_search}";

        return view('panel.states.index', compact('title', 'states', 'dataForm'));
    }
}
