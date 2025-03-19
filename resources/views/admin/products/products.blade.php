@extends('admin.components.layout')

@section('content')

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-9 offset-md-3 col-sm-2">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Список товарів</strong>
                        <a href="{{ route('product.create') }}" class="btn btn-success" >Створити товар</a>
                    </div>
                    <div class="table-stats order-table ov-h">
                        <table class="table ">
                            <thead>
                            <tr>
                                <th>Фото</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Наявність</th>
                                <th>Ціна</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $products as $product )
                            <tr>
                                <td class="avatar">
                                    <div class="round-img">
                                        <img class="rounded-circle" src="{{ asset('storage/' . $product['image_url']) }}" alt="">
                                    </div>
                                </td>
                                <td><a href="">{{ $product['name'] }} </a> </td>
                                <td> {{ $product['sku'] }}</td>
                                @if(  $product['quantity'] >= 1 )
                                <td><span class="in_stock">В наявності</span></td>
                                @else
                                 <td><span class="out_stock">Немає в наявності</span></td>
                                 @endif
                                <td> {{ $product['price'] }} грн </td>
                                <td>
                                    <a class="btn btn-warning fa fa-pencil-square-o" title="Редагувати" href="{{ route('product.edit', $product['id']) }}"></a> </td>
                                <td>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Видалити товар?');">
                                        @csrf <!-- Токен безопасности -->
                                        @method('DELETE') <!-- Имитация DELETE-запроса -->
                                        <button class="btn btn-danger fa fa-times" title="Видалити" type="submit"></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('product.duplicate', $product->id) }}" method="GET">
                                        <button type="submit" title="Дублювати" class=" fa fa-copy btn btn-primary"></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /.table-stats -->
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->





@endsection
