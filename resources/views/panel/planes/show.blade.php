@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('planes.index')}}" class="bred">Aviões > </a>
    <a href="" class="bred">{{$plane->id}}</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">{{$plane->id}}</h1>
</div>

<div class="content-din">
    <ul>
        <li>
            ID: <strong>{{$plane->id}}</strong>
        </li>
        <li>
            Marca: <strong>{{$brand}}</strong>
        </li>
        <li>
            Qtde de Passageiros: <strong>{{$plane->qty_passengers}}</strong>
        </li>
        <li>
            Classe: <strong>{{$plane->classes($plane->class)}}</strong>
        </li>
    </ul>

    <div class="messages">
        @include('panel.includes.alerts')
    </div>

    {!! Form::open(['route' => ['planes.destroy', $plane->id], 'class' => 'form form-search form-ds', 'method' => 'DELETE']) !!}

        <div class="form-group">
            {!! Form::submit('Deletar o avião', ['class' => 'btn btn-danger']) !!}
        </div>
    
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
