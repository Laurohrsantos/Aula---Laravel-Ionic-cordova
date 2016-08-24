@extends('app')

@section('content')
<div class="container">
    <h3>Cupons de Desconto</h3>
        
    <a href="{{ route('admin/cupoms/create') }}" class="btn btn-success">Novo Cupom</a><br><br> 
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Valor de Desconto</th>
                <th>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cupoms as $cupom)
            <tr>                
                <td>{{ $cupom->id }}</td>
                <td>{{ $cupom->code }}</td>
                <td>{{ $cupom->value }}</td>
                <td>
                    <a href="{{ route('admin/cupoms/edit', ['id'=>$cupom->id]) }}" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('admin/cupoms/delet', ['id'=>$cupom->id]) }}" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </td>                
            </tr>
            @endforeach
        </tbody>
        
    </table>
    
    {!! $cupoms->render() !!}
    
</div>
@endsection
