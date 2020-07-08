@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('users.index')}}" class="bred">Usuários > </a>
    <a href="" class="bred">{{$user->name}}</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Detalhes do usuário: {{$user->name}}</h1>
</div>

<div class="content-din">
    <ul>

        @if($user->image)
            <img src="{{url("storage/users/{$user->image}")}}" alt="{$user->id}" style="max-width: 200px;"/>
        @endif

        <li>
            Name: <strong>{{$user->name}}</strong>
        </li>
        <li>
            E-mail: <strong>{{$user->email}}</strong>
        </li>
        <li>
            É administrador: <strong>{{$user->is_admin ? 'SIM' : 'NÃO'}}</strong>
        </li>
    </ul>

    <div class="messages">
        @include('panel.includes.alerts')
    </div>

    {!! Form::open(['route' => ['users.destroy', $user->id], 'class' => 'form form-search form-ds', 'method' => 'DELETE']) !!}

        <div class="form-group">
            {!! Form::submit('Deletar o usuário', ['class' => 'btn btn-danger']) !!}
        </div>
    
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
