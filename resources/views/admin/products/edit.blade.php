@extends('app')

@section('content')
<div class="container">
    <h3>Editando produto: <b>{{ $product->name }}</b></h3>

    @include('errors/_check')


    {!! Form::model($product, ['route' => ['admin/products/update', $product->id]]) !!}

    @include('admin/products/_form')

    <div class="form-group">
        {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
    </div>

    {!! Form::close() !!}



</div>
@endsection
