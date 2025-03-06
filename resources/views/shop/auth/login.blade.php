@extends('shop.components.layout')

@section('content')

    <div class="section register">
        <div class="container">
            <div class="section-title">
                <h2 class="title">Авторизація</h2>
                <span class="register-link">Не зареєстровані? <a href="/registrations">Реєстрація</a></span>
                @if (!empty($message) )
                    <p style="color: green">{{ $message }}</p>
                @endif
            </div>

            <form action="/login" method="POST" class="authentication-form">
                @csrf

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="input" placeholder="Введите email"
                           value=" @if (!empty($email)){{ $email  }} @endif" required>
                    @if (!empty($error_email))
                        <p style="color: red">{{ $error_email }}</p>
                    @endif
                </div>
                <!-- Поле password -->
                <div class="form-group pass" id="pass">
                    <label for="password">Пароль:</label>
                    <span class="icon-pass" id="icon-pass">&#128065;</span>
                    <input type="password"
                           id="password"
                           value="@if (!empty($password)){{ $password  }} @endif"
                           name="password"
                           class="input"
                           placeholder="Введите пароль"
                           pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                           title="Строчные и прописные латинские буквы, цифры, спецсимволы. Минимум 8 символов"
                           required>

                    <!-- акаунт не существует -->
                    @if (!empty($error_pass))
                        <p style="color: red">{{ $error_pass }}</p>
                    @endif

                </div>

                <!-- Кнопка отправки -->
                <button type="submit" class="primary-btn">Авторизуватись</button>

            </form>
        </div>
    </div>
@endsection
