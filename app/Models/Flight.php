<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Flight extends Model
{
    protected $casts = [
        'is_promotion' => 'boolean',
    ];

    protected $fillable = [
        'plane_id', 
        'airport_origin_id', 
        'airport_destination_id', 
        'date', 
        'time_duration', 
        'hour_output', 
        'arrival_time', 
        'old_price', 
        'price', 
        'total_plots', 
        'is_promotion', 
        'image', 
        'qty_stops', 
        'description', 
    ];

    public function getItems()
    {
        return $this->with(['origin', 'destination'])
                ->paginate($this->totalPage);
    }

    public function origin() 
    {
        return $this->belongsTo(Airport::class, 'airport_origin_id');
    }

    public function destination() 
    {
        return $this->belongsTo(Airport::class, 'airport_destination_id');
    }

    public function plane()
    {
        return $this->belongsTo(Plane::class);
    }

    public function reserves()
    {
        return $this->hasMany(Reserve::class)
                        ->where('reserves.status', '<>', 'canceled');
    }

    public function search($request, $totalPage)
    {
        $flights = $this->where(function($query) use ($request) {
            if($request->code)
                $query->where('id', $request->code);
            
            if($request->date)
                $query->where('date', '>=', $request->date);

            if($request->hour_output)
                $query->where('id', $request->hour_output);

            if($request->total_stops)
                $query->where('total_stops', $request->total_stops);

            if($request->origin)
                $query->where('airport_origin_id', $request->origin);

            if($request->destination)
                $query->where('airport_destination_id', $request->destination);
        })->paginate($totalPage);

        return $flights;
    }

    public function searchFlights($origin, $destination, $date)
    {
        return $this->where('flights.airport_origin_id', $origin)
                    ->where('flights.airport_destination_id', $destination)
                    ->where('flights.date', $date)
                    ->get();
    }

    public function promotions()
    {
        return $this->where('is_promotion', true)
                ->where('date', '>=', date('Y-m-d'))
                ->with(['origin.city', 'destination.city'])
                ->get();
    }
}
