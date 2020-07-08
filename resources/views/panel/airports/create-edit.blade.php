@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('airports.index', $city->id)}}" class="bred">Cidade {{$city->name}}</a>
    <a href="" class="bred">Gestão</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Gestão de Aeroportos na cidade {{$city->name}}</h1>
</div>

<div class="content-din">

    @include('panel.includes.errors')

    @if(isset($airport))
        <!--<form class="form form-search form-ds" action="{{route('airports.update', ['airports.update', $city->id])}}" method="post">-->

        {!! Form::model($airport, ['route' => ['airports.update', $city->id, $airport->id], 'class' => 'form form-search form-ds', 'method' => 'PUT']) !!}
    @else
        <!--<form class="form form-search form-ds" action="{{route('airports.store', ['airports.store', $city->id])}}" method="post">-->

        {!! Form::open(['route' => ['airports.store', $city->id], 'class' => 'form form-search form-ds']) !!}
    @endif

    @include('panel.airports.form')

    {!! Form::close() !!}
    <!--</form>-->

</div><!--Content Dinâmico-->

@endsection
