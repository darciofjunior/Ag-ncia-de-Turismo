<div class="form-search">
    {!! Form::open(['route' => 'reserves.search', 'class' => 'form form-inline']) !!}
        {!! Form::text('user', null, ['class' => 'form-control', 'placeholder' => 'Detalhes do Usuário']) !!}

        {!! Form::text('reserve', null, ['class' => 'form-control', 'placeholder' => 'Detalhes da Reserva']) !!}

        {!! Form::date('date', null, ['class' => 'form-control', 'placeholder' => 'Data do Vôo']) !!}

        {!! Form::select('status', [
                'reserved'  => 'Reservado',
                'canceled'  => 'Cancelado',
                'paid'      => 'Pago',
                'concluded' => 'Concluído',
        ], null, ['class' => 'form-control']) !!}

        {!! Form::submit('Pesquisar', ['class' => 'btn btn-search']) !!}
    {!! Form::close() !!}

    @if(isset($dataForm))
        <div class="alert alert-info">
            <p>
                <a href="{{route('reserves.index')}}">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </a>

                @if(isset($dataForm['user']))
                    <p>Usuário: <strong>{{$dataForm['user']}}</strong></p>
                @endif

                @if(isset($dataForm['reserve']))
                    <p>Reserva: <strong>{{$dataForm['reserve']}}</strong></p>
                @endif
                
                @if(isset($dataForm['date']))
                    <p>Data: <strong>{{formatDateAndTime($dataForm['date'])}}</strong></p>
                @endif
            </p>
        </div>
    @endif
</div>