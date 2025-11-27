@extends('layouts.app')

@section('title', 'Register')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="main__container">
        <div class="card">
            <h2 class="page-title">Register</h2>

            <form action="{{ route('register') }}" method="POST" class="form">
                @csrf

                <div class="form__group">
                    <label class="form__label">お名前</label>
                    <input type="text" name="name" class="form__input--text" placeholder="例: 山田太郎" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form__group">
                    <label class="form__label">メールアドレス</label>
                    <input type="email" name="email" class="form__input--text" placeholder="例: test@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form__group">
                    <label class="form__label">パスワード</label>
                    <input type="password" name="password" class="form__input--password" placeholder="例: coachtech1234" required autocomplete="new-password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="form__button">登録</button>
            </form>
        </div>
    </div>
@endsection
