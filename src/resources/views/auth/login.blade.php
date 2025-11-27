@extends('layouts.app')

@section('title', 'Login')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login-form__wrapper">

        <h2 class="login-form__title">Login</h2>

        <form action="{{ route('login') }}" method="POST" class="form">
            @csrf

            <div class="form__group">
                <label class="form__label">メールアドレス</label>
                <input type="email" name="email" class="form__input--text" placeholder="例: test@example.com" value="{{ old('email') }}" required> {{-- class="form__input--text" を追加 --}}
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">パスワード</label>
                <input type="password" name="password" class="form__input--password" placeholder="例: coachtech1234" required autocomplete="current-password"> {{-- class="form__input--password" を追加 --}}
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            @if ($errors->has('login_error'))
                <div class="alert alert-danger"> {{-- ここはHTMLのまま --}}
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <button type="submit" class="form__button">ログイン</button>
        </form>
    </div>
@endsection
