@extends('shop.components.layout')



@section('content')

    <div class="card">
        <div class="container">
            <h1>Кошик</h1>
            <div class="row">
                @if ($cart === [])
                    <p>Кошик пустий</p>
                @else
                    <div class="col-md-12 offset-md-3 mr-auto ml-auto mx-auto">

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Фото</th>
                                    <th scope="col">Назва</th>
                                    <th scope="col">Кількість</th>
                                    <th scope="col">Ціна</th>
                                    <th scope="col">Видалити</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $total = 0; @endphp
                                @foreach($cart as $item)
                                    @php $total += $item['price'] * $item['quantity']; @endphp
                                    <tr>
                                        <th scope="row">
                                            <img src="{{ asset('storage/' . $item['image_url']) }}" width="100" alt="{{ $item['name'] }}">
                                        </th>
                                        <td>{{ $item['name'] }}</td>
                                        <td>
                                            <div class="btn_qnt">
                                                <button class="decrease fa fa-minus" data-id="{{ $item['product_id'] }}"></button>
                                                <span class="quantity" data-id="{{ $item['product_id'] }}">{{ $item['quantity'] }}</span>
                                                <button class="increase fa fa-plus" data-id="{{ $item['product_id'] }}"></button>
                                            </div>
                                        </td>

                                        <td>{{ $item['price'] }} грн</td>
                                        <td>
                                            <button class="remove-item fa fa-trash" data-id="{{ $item['product_id'] }}"></button>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">Сума замовлення</td>
                                    <td colspan="2" id="total-price">{{ $total }} грн</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="cart-button">
                                <a href="{{ route('checkout.checkout') }}">Оформлення замовлення</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('shop/js/cart.js') }}"></script>
@endpush
