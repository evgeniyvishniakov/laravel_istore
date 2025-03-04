@extends('shop/components/layout')

@section('content')
    <div class="section register">
        <div class="container">
            <div class="section-title">
                <h2 class="title">Registration</h2>
            </div>
            <form action="/registration" method="POST" class="registration-form">

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="input" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="input" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="primary-btn">Register</button>

            </form>
        </div>
    </div>
@endsection
