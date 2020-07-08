@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="{{route('panel')}}" class="bred">Home > </a>
    <a href="{{route('users.index')}}" class="bred">Users > </a>
    <a href="" class="bred">Gestão</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Gestão de Usuário</h1>
</div>

<div class="content-din">

    @include('panel.includes.errors')

    @if(isset($user))
        <!--<form class="form form-search form-ds" action="{{route('users.update', $user->id)}}" method="post">-->

        {!! Form::model($user, ['route' => ['users.update', $user->id], 'class' => 'form form-search form-ds', 'files' => true, 'method' => 'PUT']) !!}
    @else
        <!--<form class="form form-search form-ds" action="{{route('users.store')}}" method="post">-->

        {!! Form::open(['route' => 'users.store', 'class' => 'form form-search form-ds', 'files' => true]) !!}
    @endif

    @include('panel.users.form')
        
    <!--</form>-->
    {!! Form::close() !!}

</div><!--Content Dinâmico-->

@endsection
