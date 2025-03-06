@extends('shop.components.layout')

@section('content')

    <div class="section register">
        <div class="container">
            <div class="section-title">
                <h2 class="title">Registration</h2>
            </div>

            <form action="/registrations" method="POST" class="registration-form">
                @csrf

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="input" placeholder="Введите email"
                           value=" {{ $email  }} " required>
                    @if (!empty($message_email))
                        <p style="color: red">{{ $message_email }}</p>
                    @endif

                </div>

                <!-- Поле password -->
                <div class="form-group pass" id="pass">
                    <label for="password">Пароль:</label>
                    <span class="icon-pass" id="icon-pass">&#128065;</span>
                    <input type="password"
                           id="password"
                           value="{{ $password }}"
                           name="password"
                           class="input"
                           placeholder="Введите пароль"
                           pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                           title="Строчные и прописные латинские буквы, цифры, спецсимволы. Минимум 8 символов"
                           required>

                </div>

                <!-- Подтверждение пароля -->
                <div class="form-group">
                    <label for="password_confirmation">Подтвердите пароль:</label>
                    <input type="password" id="password_confirmation" value="{{ old('password_confirmation') }}"
                           name="password_confirmation" class="input"
                           placeholder="Повторите пароль" required>
                    @if (!empty($message) )
                        <p style="color: red">{{ $message }}</p>
                    @endif
                </div>

                <!-- Кнопка отправки -->
                <button type="submit" name="register" class="primary-btn">Зарегистрироваться</button>

            </form>
        </div>
    </div>
@endsection
