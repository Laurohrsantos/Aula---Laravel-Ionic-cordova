@extends('app')

@section('content')
<div class="container">
    <h3>Categorias</h3>
        
    <a href="{{ route('admin/categories/create') }}" class="btn btn-success">Nova Categoria</a><br><br> 
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $category)
            <tr>                
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('admin/categories/edit', ['id'=>$category->id]) }}" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('admin/categories/delet', ['id'=>$category->id]) }}" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </td>                
            </tr>
            @endforeach
        </tbody>
        
    </table>
    
    {!! $categories->render() !!}
    
</div>
@endsection
