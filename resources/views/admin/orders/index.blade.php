@extends('app')

@section('content')
<div class="container">
    <h3>Pedidos</h3>
        
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Data</th>
                <th>Itens</th>                
                <th>Entregador</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $order)
            <tr>                
                <td>#{{ $order->id }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    @foreach($order->items as $item)
                        <li>{{ $item->product->name }}</li>   
                    @endforeach
                </td>                
                <td>
                    @if($order->deliveryman)
                        {{ $order->deliveryman->name }}
                    @else
                        --
                    @endif
                </td>
                <td>{{ $list_status{$order->status} }}</td>
                <td>
                    <a href="{{ route('admin/orders/edit', ['id'=>$order->id]) }}" class="btn btn-info btn-sm">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                </td>                
            </tr>
            @endforeach
        </tbody>
        
    </table>
    
    {!! $orders->render() !!}
    
</div>
@endsection
