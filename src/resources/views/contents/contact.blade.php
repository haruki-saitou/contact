@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <div class="contact-form__wrapper">
        <h2 class="contact-form__title">Contact</h2>

        <form method="POST" action="{{ route('contact.confirm') }}" class="form">
            @csrf

            <div class="form__group">
                <label class="form__label">お名前<span class="required">※</span></label>
                <input type="text" name="last_name" placeholder="例: 山田"
                    value="{{ $input['last_name'] ?? old('last_name') }}">
                @error('last_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <input type="text" name="first_name" placeholder="例: 太郎"
                    value="{{ $input['first_name'] ?? old('first_name') }}">
                @error('first_name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">性別<span class="required">※</span></label>
                <label><input type="radio" name="gender" value="1"
                        {{ (isset($input['gender']) && $input['gender'] == '1') || old('gender') == '1' ? 'checked' : '' }}>
                    男性</label>
                <label><input type="radio" name="gender" value="2"
                        {{ (isset($input['gender']) && $input['gender'] == '2') || old('gender') == '2' ? 'checked' : '' }}>
                    女性</label>
                <label><input type="radio" name="gender" value="3"
                        {{ (isset($input['gender']) && $input['gender'] == '3') || old('gender') == '3' ? 'checked' : '' }}>
                    その他</label>
                @error('gender')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form__group">
                <label class="form__label">メールアドレス<span class="required">※</span></label>
                <input type="email" name="email" placeholder="例: test@example.com"
                    value="{{ $input['email'] ?? old('email') }}">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form__group">
                <label class="form__label">電話番号<span class="required">※</span></label>
                <input type="tel" name="tel1" placeholder="090" value="{{ $input['tel1'] ?? old('tel1') }}">
                @error('tel1')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                -
                <input type="tel" name="tel2" placeholder="1234" value="{{ $input['tel2'] ?? old('tel2') }}">
                @error('tel2')
                    <span class="error-message">{{ $message }}</span>
                @enderror -
                <input type="tel" name="tel3" placeholder="5678" value="{{ $input['tel3'] ?? old('tel3') }}">
                @error('tel3')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form__group">
                <label class="form__label">住所<span class="required">※</span></label>
                <input type="text" name="address" placeholder="例: 東京都渋谷区恵比寿1-2-3"
                    value="{{ $input['address'] ?? old('address') }}">
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">建物名</label>
                <input type="text" name="building" placeholder="例: 恵比寿マンション101"
                    value="{{ $input['building'] ?? old('building') }}">
            </div>


            <div class="form__group">
                <label class="form__label">お問い合わせの種類<span class="required">※</span></label>
                <select name="category_id">
                    <option value="" disabled selected>選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (isset($input['category_id']) && $input['category_id'] == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>






            <div class="form__group">
                <label class="form__label">お問い合わせ内容<span class="required">※</span></label>
                <textarea name="detail">{{ $input['detail'] ?? old('detail') }}</textarea>
            </div>

            <button type="submit" class="form__button">確認</button>
        </form>
    </div>
@endsection
