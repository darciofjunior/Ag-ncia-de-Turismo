@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('flights.index')}}" class="bred">Vôos > </a>
    <a href="" class="bred">{{$flight->id}}</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Detalhes do vôo: {{$flight->id}}</h1>
</div>

<div class="content-din">
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
            Foto: <strong>{{$flight->image}}</strong>
        </li>
        <li>
            Qtde de Paradas: <strong>{{$flight->qty_stops}}</strong>
        </li>
        <li>
            Descrição: <strong>{{$flight->description}}</strong>
        </li>
    </ul>

    <div class="messages">
        @include('panel.includes.alerts')
    </div>

    {!! Form::open(['route' => ['flights.destroy', $flight->id], 'class' => 'form form-search form-ds', 'method' => 'DELETE']) !!}

        <div class="form-group">
            {!! Form::submit('Deletar o vôo', ['class' => 'btn btn-danger']) !!}
        </div>
    
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
