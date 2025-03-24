@extends('shop.components.layout')



@section('content')


		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
                @if(empty($cart) || count($cart) == 0)
                    <div class="alert alert-warning">Ваша корзина пуста!</div>
                @else
				<!-- row -->
				<div class="row">
                    <form action="" method="POST">
                        @csrf
                        <div class="col-md-7">
                            <!-- Billing Details -->
                            <div class="billing-details">
                                <div class="section-title">
                                    <h3 class="title">Ваші данні</h3>
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="first-name" placeholder="First Name">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="last-name" placeholder="Last Name">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="tel" name="tel" placeholder="Telephone">
                                </div>
                                <div class="form-group">
                                    <div class="input-checkbox">
                                        <input type="checkbox" id="create-account">
                                        <label for="create-account">
                                            <span></span>
                                            Create Account?
                                        </label>
                                        <div class="caption">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p>
                                            <input class="input" type="password" name="password" placeholder="Enter Your Password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Billing Details -->


                            <!-- Order notes -->
                            <div class="delivered">
                                <p>Доставка Нова Пошта</p>
                                <select name="" id="">
                                    @if (!empty($cities) && isset($cities['result']) && is_array($cities['result']))
                                        @foreach ($cities['result'] as $city)
                                            <option value="{{ $city['Ref'] }}">{{ $city['Description'] }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>Города не загружены</option>
                                    @endif
                                </select>
                                <label for="warehouse">Отделение</label>
                                <select id="warehouse" name="warehouse">
                                    <option value="">Выберите отделение</option>
                                </select>
                            </div>
                            <!-- /Order notes -->
                        </div>

                        <!-- Order Details -->
                        <div class="col-md-5 order-details">
                            <div class="section-title text-center">
                                <h3 class="title">Ваше замовлення</h3>
                            </div>
                            <div class="order-summary">
                                <div class="order-col">
                                    <div><strong>Товари</strong></div>
                                    <div><strong>Ціна</strong></div>
                                </div>
                                <div class="order-products">
                                    @php $total = 0; @endphp
                                    @foreach($cart as $item)
                                        @php
                                            $total += $item['price'] * $item['quantity'];
                                        @endphp
                                    <div class="order-col">
                                        <div><img src="{{ asset('storage/' . $item['image_url']) }}" width="100" alt="{{ $item['name'] }}"></div>
                                        <div>{{ $item['quantity'] }}x {{ $item['name'] }}</div>
                                        <div>{{ $item['price'] }} грн</div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="order-col">
                                    <div><strong>Сума</strong></div>
                                    <div><strong class="order-total">{{ $total }} грн</strong></div>
                                </div>
                            </div>
                            <div class="payment-method">
                                <div class="input-radio">
                                    <input type="radio" name="payment" id="payment-1">
                                    <label for="payment-1">
                                        <span></span>
                                        Direct Bank Transfer
                                    </label>
                                    <div class="caption">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                                <div class="input-radio">
                                    <input type="radio" name="payment" id="payment-2">
                                    <label for="payment-2">
                                        <span></span>
                                        Cheque Payment
                                    </label>
                                    <div class="caption">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                                <div class="input-radio">
                                    <input type="radio" name="payment" id="payment-3">
                                    <label for="payment-3">
                                        <span></span>
                                        Paypal System
                                    </label>
                                    <div class="caption">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="input-checkbox">
                                <input type="checkbox" id="terms">
                                <label for="terms">
                                    <span></span>
                                    I've read and accept the <a href="#">terms & conditions</a>
                                </label>
                            </div>
                            <a href="#" class="primary-btn order-submit">Замовити</a>
                        </div>
                    </form>
					<!-- /Order Details -->
				</div>
				<!-- /row -->
                @endif
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->



@endsection
@push('scripts')
    <script src="{{ asset('shop/js/checkout.js') }}"></script>
@endpush
