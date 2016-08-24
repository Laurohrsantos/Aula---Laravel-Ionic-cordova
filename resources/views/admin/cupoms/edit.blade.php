@extends('app')

@section('content')
<div class="container">
    <h3>Editando Cupom: <b>{{ $cupom->code }}</b></h3>

    @include('errors/_check')


    {!! Form::model($cupom, ['route' => ['admin/cupoms/update', $cupom->id]]) !!}

    @include('admin/cupoms/_form')

    <div class="form-group">
        {!! Form::submit('Salvar Cupom', ['class'=>'btn btn-success']) !!}
    </div>

    {!! Form::close() !!}



</div>
@endsection
