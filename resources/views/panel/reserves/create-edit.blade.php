@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('reserves.index')}}" class="bred">Reserves > </a>
    <a href="" class="bred">Gestão</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Gestão de Reserva</h1>
</div>

<div class="content-din">

    @include('panel.includes.errors')

    @if(isset($reserve))

        {!! Form::model($reserve, ['route' => ['reserves.update', $reserve->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'PUT']) !!}
            <div class="form-group">
                <label for="status">Status: </label>
                {!! Form::select('status', $status, null, ['class' => 'form-control']) !!}
            </div>
    @else
        
        {!! Form::open(['route' => 'reserves.store', 'class' => 'form form-search form-ds', 'files' => true]) !!}
            @include('panel.reserves.form')
    @endif

        <div class="form-group">
            {!! Form::submit('Enviar', ['class' => 'btn btn-search']) !!}
        </div>
        
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
