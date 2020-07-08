@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('flights.index')}}" class="bred">Flights > </a>
    <a href="" class="bred">Gestão</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Gestão de Vôo</h1>
</div>

<div class="content-din">

    @include('panel.includes.errors')

    @if(isset($flight))
        <!--<form class="form form-search form-ds" action="{{route('flights.update', $flight->id)}}" method="post">-->

        {!! Form::model($flight, ['route' => ['flights.update', $flight->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'PUT']) !!}
    @else
        <!--<form class="form form-search form-ds" action="{{route('flights.store')}}" method="post">-->

        {!! Form::open(['route' => 'flights.store', 'class' => 'form form-search form-ds', 'files' => true]) !!}
    @endif

    @include('panel.flights.form')
        
    <!--</form>-->
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
