<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Electro - HTML Ecommerce Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('shop/css/bootstrap.min.css')  }}"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('shop/css/slick.css')  }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('shop/css/slick-theme.css')  }}"/>

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('shop/css/nouislider.min.css')  }}"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('shop/css/font-awesome.min.css')  }}">

    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="{{ asset('shop/css/style.css')  }}">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
            </ul>
            <ul class="header-links pull-right">
                <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
                @if (Auth::check())
                    <li><a href="/login"><i class="fa fa-user-o"></i>В кабінет</a>   <span style="color: white">/</span>   <a href="/logout">Вихід</a></li>
                @else
                <li><a href="/login"><i class="fa fa-user-o"></i> Мій акаунт</a></li>
                @endif
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="#" class="logo">
                            <img src="./img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <form>
                            <select class="input-select">
                                <option value="0">All Categories</option>
                                <option value="1">Category 01</option>
                                <option value="1">Category 02</option>
                            </select>
                            <input class="input" placeholder="Search here">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            <a href="#">
                                <i class="fa fa-heart-o"></i>
                                <span>Your Wishlist</span>
                                <div class="qty">2</div>
                            </a>
                        </div>
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Кошик</span>
                                <div class="qty">{{ count($cartData) ?? 0 }}</div> <!-- Количество товаров в корзине -->
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    @if(!empty($cartData)) <!-- Проверка, что корзина не пуста -->
                                    @foreach($cartData as $item)
                                        <div class="product-widget">
                                            <div class="product-img">
                                                <img src="{{ asset('storage/' . $item['image_url']) }}" alt="{{ $item['name'] }}">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><a href="#">{{ $item['name'] }}</a></h3>
                                                <h4 class="product-price"><span class="qty">Кількість: {{ $item['quantity'] }}</span> {{ $item['price'] }} грн</h4>
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                        <p>Корзина пуста</p> <!-- Сообщение, если корзина пуста -->
                                    @endif
                                </div>
                                <div class="cart-summary">
                                    <small>{{ count($cartData) }} товари</small>
                                    @php
                                        $total = 0;
                                        foreach($cartData as $item) {
                                            $total += $item['price'] * $item['quantity'];
                                        }
                                    @endphp
                                    <h5>Сума: {{ $total }} грн</h5> <!-- Подсчёт общей суммы -->
                                </div>
                                <div class="cart-btns">
                                    <a href="{{ route('cart.show') }}">До Кошику</a>
                                    <a href="#">Оформлення</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->
<!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Hot Deals</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">Laptops</a></li>
                <li><a href="#">Smartphones</a></li>
                <li><a href="#">Cameras</a></li>
                <li><a href="#">Accessories</a></li>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">All Categories</a></li>
                    <li><a href="#">Accessories</a></li>
                    <li class="active">Headphones (227,490 Results)</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
