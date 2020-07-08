@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('planes.index')}}" class="bred">Planes > </a>
    <a href="" class="bred">Gestão</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Gestão de Avião</h1>
</div>

<div class="content-din">

    @include('panel.includes.errors')

    @if(isset($plane))
        <!--<form class="form form-search form-ds" action="{{route('planes.update', $plane->id)}}" method="post">-->

        {!! Form::model($plane, ['route' => ['planes.update', $plane->id], 'class' => 'form form-search form-ds', 'method' => 'PUT']) !!}
    @else
        <!--<form class="form form-search form-ds" action="{{route('planes.store')}}" method="post">-->

        {!! Form::open(['route' => 'planes.store', 'class' => 'form form-search form-ds']) !!}
    @endif

    @include('panel.planes.form')
        
    <!--</form>-->
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
