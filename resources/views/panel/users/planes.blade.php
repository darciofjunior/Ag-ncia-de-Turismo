@extends('panel.layouts.app')

@section('content')

<div class="bred">
    <a href="" class="bred">Home</a>
    <a href="{{route('brands.index')}}" class="bred">Marcas</a>
    <a href="{{route('brands.planes', $brand->id)}}" class="bred">Aviões</a>
</div>

<div class="title-pg">
    <h1 class="title-pg">Aviões da Marca: 
        <strong>{{$brand->name}}</strong>
    </h1>
</div>

<div class="content-din bg-white">

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Total de Passageiros</th>
            <th>Classe</th>
            <th width="150">Ações</th>
        </tr>

        @forelse($planes as $plane)
            <tr>
                <td>{{$plane->id}}</td>
                <td>{{$plane->qty_passengers}}</td>
                <td>{{$plane->classes($plane->class)}}</td>
                <td>
                    <a href="{{route('planes.edit', $plane->id)}}" class="edit">Edit</a>
                    <a href="{{route('planes.show', $plane->id)}}" class="delete">Delete</a>
                </td>
            </tr>
        @empty
            <tr>
                <td>Nenhum item cadastrado !</td>
            </tr>
        @endforelse
    </table>

</div><!--Content Dinâmico-->

@endsection