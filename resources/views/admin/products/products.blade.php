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
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Наявність</th>
                                <th>Ціна</th>
                                <th>Фото</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $products as $product )
                            <tr>
                                <td><a href="">{{ $product['name'] }}</a> </td>
                                <td> {{ $product['sku'] }}</td>
                                @if(  $product['qnt'] >= 1 )
                                <td><span class="in_stock">В наявності</span></td>
                                @else
                                 <td><span class="out_stock">Немає в наявності</span></td>
                                 @endif
                                <td> {{ $product['price'] }} грн </td>
                                <td class="avatar">
                                    <div class="round-img">
                                        <a href="#"><img class="rounded-circle" src="" alt=""></a>
                                    </div>
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
