
@extends('shop/components/layout')



@section('content')

    <div class="sidebar-account">
        <h2>Меню</h2>
        <ul>
            <li onclick="showContent('profile')">Профиль</li>
            <li onclick="showContent('liked')">Понравившиеся товары</li>
            <li onclick="showContent('password')">Смена пароля</li>
            <li onclick="showContent('orders')">Мои заказы</li>
        </ul>
    </div>

    <!-- Контент -->
    <div class="content" id="profile">
        <h3>Профиль</h3>
        <p>Здесь вы можете просматривать и редактировать свой профиль.</p>
    </div>

    <div class="content" id="liked">
        <h3>Понравившиеся товары</h3>
        <p>Здесь отображаются товары, которые вы добавили в избранное.</p>
    </div>

    <div class="content" id="password">
        <h3>Смена пароля</h3>
        <p>Здесь вы можете изменить свой пароль для доступа к аккаунту.</p>
    </div>

    <div class="content" id="orders">
        <h3>Мои заказы</h3>
        <p>Здесь вы можете просматривать информацию о своих заказах.</p>
    </div>


@endsection
