@extends('site.layouts.app')

@section('content-site')

<div class="content">

    <section class="container">
        <h1 class="title">Detalhes do voô {{$flight->id}}</h1>

        <ul>
            <li>
                Código: <strong>{{$flight->id}}</strong>
            </li>
            <li>
                Origem: <strong>{{$flight->origin->name}}</strong>
            </li>
            <li>
                Destino: <strong>{{$flight->destination->name}}</strong>
            </li>
            <li>
                Data: <strong>{{formatDateAndTime($flight->date)}}</strong>
            </li>
            <li>
                Duração: <strong>{{formatDateAndTime($flight->time_duration, 'H:i')}}</strong>
            </li>
            <li>
                Horas Saída: <strong>{{formatDateAndTime($flight->hour_output, 'H:i')}}</strong>
            </li>
            <li>
                Horas Chegada: <strong>{{formatDateAndTime($flight->arrival_time, 'H:i')}}</strong>
            </li>
            <li>
                Preço Anterior: <strong>{{number_format($flight->old_price, 2, ',', '.')}}</strong>
            </li>
            <li>
                Preço: <strong>{{number_format($flight->price, 2, ',', '.')}}</strong>
            </li>
            <li>
                Total de Paradas: <strong>{{$flight->total_plots}}</strong>
            </li>
            <li>
                É promoção: <strong>{{$flight->is_promotion ? 'SIM' : 'NÃO'}}</strong>
            </li>
            <li>
                Qtde de Paradas: <strong>{{$flight->qty_stops}}</strong>
            </li>
            <li>
                Descrição: <strong>{{$flight->description}}</strong>
            </li>
        </ul>
    </section><!--Container-->

    @include('panel.includes.errors')

    {!! Form::open(['route' => 'reserve.flight']) !!}
        {!! Form::hidden('user_id', auth()->user()->id) !!}
        {!! Form::hidden('flight_id', $flight->id) !!}
        {!! Form::hidden('date_reserved', date('Y-m-d')) !!}
        {!! Form::hidden('status', 'reserved') !!}

        <button type="submit" class="btn btn-success">Reserver Agora</button>
    {!! Form::close() !!}

</div>

@endsection