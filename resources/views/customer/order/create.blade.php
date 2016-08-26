@extends('app')

@section('content')
<div class="container">
    <h3>Novo Pedido</h3>

    @include('errors/_check')

    {!! Form::open(['route' => 'customer/order/store','class' => 'form']) !!}

    <div class="form-group">
        <label>Total: </label>
        <p id="total"></p>
        <a href="#" id="btnNewItem" class="btn btn-default">Novo Item</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <th>Produto</th>
        <th>Quantidade</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" name="items[0][product_id]" required="required">
                        <option value="">Selecione Produtos</option>
                        @foreach($products as $p)
                        <option value="{{$p->id}}" data-price="{{$p->price}}">{{$p->name . ' - R$ '. $p->price}}</option>
                        @endforeach
                    </select>
                </td>
                <td>{!! Form::text('items[0][qtd]', 1,['class' => 'form-control']) !!}</td>
            </tr>
        </tbody>
    </table>

    <div class="form-group">
        {!! Form::submit('Finalizar Pedido', ['class'=>'btn btn-success']) !!}
    </div>


    {!! Form::close() !!}  

</div>


@endsection

@section('post-script')
<script type="text/javascript">

    $('#btnNewItem').click(function ()
    {
        var row = $('table tbody > tr:last'),
                newRow = row.clone(),
                lenght = $("table tbody tr").length;

        newRow.find('td').each(function () {
            var td = $(this), input = td.find('input, select'),
                    name = input.attr('name');
            input.attr('name', name.replace((lenght - 1) + "", lenght + ""));

        });

        newRow.find('input').val(1);
        newRow.insertAfter(row);
    });

    $(document.body).on('click', 'select', function () {
        calculateTotal();
    });

    $(document.body).on('blur', 'input', function () {
        calculateTotal();
    });

    function calculateTotal()
    {
        var total = 0;
        var trLen = $('table tbody tr').length;
        var td = null;
        var price, qtd;

        for (var i = 0; i < trLen; i++)
        {
            tr = $('table tbody tr').eq(i);
            price = tr.find(':selected').data('price');
            qtd = tr.find('input').val();
            total += price * qtd;
        }

        $('#total').html(total);
    }
</script>

@endsection
