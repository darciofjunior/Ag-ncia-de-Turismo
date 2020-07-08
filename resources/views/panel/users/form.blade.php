<div class="form-group">
    <label for="name">Nome: </label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="email">Email: </label>
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="password">Senha: </label>
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

@if(isset($user->image))
<div class="form-group">
    <label for="image">Imagem Atual: </label>
    <img src="{{url("storage/users/{$user->image}")}}" alt="{$user->id}" style="max-width: 200px;"/>
</div>
@endif

<div class="form-group">
    <label for="image">Imagem: </label>
    {!! Form::file('image', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::checkbox('is_admin', null, null, ['id' => 'is_admin']) !!}
    <label for="is_admin">É administrador ?</label>
</div>

<div class="form-group">
    {!! Form::submit('Enviar', ['class' => 'btn btn-search']) !!}
</div>
