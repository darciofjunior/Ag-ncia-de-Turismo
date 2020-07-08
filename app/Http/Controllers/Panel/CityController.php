<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;

class CityController extends Controller
{
    private $city;

    private $totalPage = 20;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function index($initials)
    {
        $state = State::where('initials', $initials)->get()->first();

        if(!$state)
            return redirect()->back();

        $cities = $state->cities()->paginate($this->totalPage);
        
        $title = "Cidades do estado {$state->name}";
      
        return view('panel.cities.index', compact('title','state', 'cities'));
    }

    public function search(Request $request, $initials) {
        $state = State::where('initials', $initials)->get()->first();

        if(!$state)
            return redirect()->back();

        $dataForm   = $request->all();
        $keySearch  = $request->key_search;

        $cities = $state->searchCities($keySearch, $this->totalPage);
        
        $title = "Cidades do estado {$state->name}";
      
        return view('panel.cities.index', compact('title','state', 'cities', 'dataForm'));
    }
}
