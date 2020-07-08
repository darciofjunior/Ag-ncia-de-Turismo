<div class="form-group">
    <label for="user_id">Escolha o Usuário: </label>
    {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="flight_id">Escolha o Vôo: </label>
    {!! Form::select('flight_id', $flights, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label for="date_reserved">Data Reserva: </label>
    {!! Form::date('date_reserved', date('Y-m-d'), ['class' => 'form-control', 'placeholder' => 'Data Reserva']) !!}
</div>

<div class="form-group">
    <label for="status">Status: </label>
    {!! Form::select('status', $status, null, ['class' => 'form-control']) !!}
</div>
