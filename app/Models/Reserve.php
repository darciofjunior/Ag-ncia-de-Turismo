<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $fillable = ['user_id', 'flight_id', 'date_reserved', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(flight::class);
    }

    public function status($option = null)
    {
        $statusAvailable = [
            'reserved'  => 'Reservado',
            'canceled'  => 'Cancelado',
            'paid'      => 'Pago',
            'concluded' => 'Concluído',
        ];

        if($option)
            return $statusAvailable[$option];

        return $statusAvailable;
    }

    public function search($request, $totalPage)
    {
        /*$this->where(function($query) use ($request) {
            if($request->date)

        })->paginate($totalPage);*/

        $reserves = $this->join('users', 'users.id', '=', 'reserves.user_id')
                    ->join('flights', 'flights.id', '=', 'reserves.flight_id')
                    ->select('reserves.*', 'users.name AS user_name', 'users.email AS user_email', 'users.id AS user_id', 'flights.id AS flight_id', 'flights.date AS flight_date')
                    ->where(function($query) use ($request) {
                        if($request->user) {
                            $dataUser = $request_user;

                            $query->where(function($qr) use ($dataUser) {
                                $qr->where('users.name', 'LIKE', "%{$dataUser}%");
                                $qr->OrWhere('users.email', $dataUser);
                            });
                        }

                        if($request->date)
                            $query->where('flights.date', '=', $request->date);

                        if($request->reserve)
                            $query->where('reserves.id', $request->reserve);
                    })
                    ->where('reserves.status', $request->status)
                    ->paginate($totalPage);
        return $reserves;
    }

    public function newReserve($flightId)
    {
        $this->user_id          = auth()->user()->id;
        $this->flight_id        = $flightId;
        $this->date_reserved    = date('Y-m-d');
        $this->status           = 'reserved';

        return $this->save();
    }
}
