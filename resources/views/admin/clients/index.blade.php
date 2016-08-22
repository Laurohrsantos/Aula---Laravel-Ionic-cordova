@extends('app')

@section('content')
<div class="container">
    <h3>Clientes</h3>
        
    <a href="{{ route('admin/clients/create') }}" class="btn btn-success">Novo Cliente</a><br><br> 
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Cidade/Estado</th>
                <th>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach($clients as $client)
            <tr>                
                <td>{{ $client->id }}</td>
                <td>{{ $client->user->name }}</td>
                <td>{{ $client->address }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->city }}/{{ $client->state }}</td>
                <td>
                    <a href="{{ route('admin/clients/edit', ['id'=>$client->id]) }}" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('admin/clients/delet', ['id'=>$client->id]) }}" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </td>                
            </tr>
            @endforeach
        </tbody>
        
    </table>
    
    {!! $clients->render() !!}
    
</div>
@endsection
