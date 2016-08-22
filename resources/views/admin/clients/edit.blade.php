@extends('app')

@section('content')
<div class="container">
    <h3>Editando cliente: <b>{{ $client->user->name }}</b></h3>

    @include('errors/_check')


    {!! Form::model($client, ['route' => ['admin/clients/update', $client->id]]) !!}

    @include('admin/clients/_form')

    <div class="form-group">
        {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
    </div>

    {!! Form::close() !!}



</div>
@endsection
