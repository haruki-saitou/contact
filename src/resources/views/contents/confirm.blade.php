@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
    <div class="confirm__wrapper">
        <h2 class="confirm__title">Confirm</h2>

        <form method="POST" action="{{ route('contact.send') }}" class="form">
            @csrf

            @foreach ($input as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach


            <table class="confirm__table">

                <tr>
                    <th class="confirm__label">お名前</th>
                    <td class="confirm__data">
                        {{ $input['last_name'] }} {{ $input['first_name'] }}
                    </td>
                </tr>

                <tr>
                    <th class="confirm__label">性別</th>
                    <td class="confirm__data">
                        {{ $input['gender'] == '1' ? '男性' : ($input['gender'] == '2' ? '女性' : 'その他') }}
                    </td>
                </tr>

                <tr>
                    <th class="confirm__label">お問い合わせの種類</th>
                    <td class="confirm__data">
                        {{ $category->content }}
                    </td>
                </tr>

                <tr>
                    <th class="confirm__label">メールアドレス</th>
                    <td class="confirm__data">{{ $input['email'] }}</td>
                </tr>

                <tr>
                    <th class="confirm__label">電話番号</th>
                    <td class="confirm__data">
                        {{ $input['tel1'] }}-{{ $input['tel2'] }}-{{ $input['tel3'] }}
                    </td>
                </tr>

                <tr>
                    <th class="confirm__label">住所</th>
                    <td class="confirm__data">{{ $input['address'] }}</td>
                </tr>

                <tr>
                    <th class="confirm__label">建物名</th>
                    <td class="confirm__data">{{ $input['building'] }}</td>
                </tr>

                <tr>
                    <th class="confirm__label">お問い合わせ内容</th>
                    <td class="confirm__data">{{ $input['detail'] }}</td>
                </tr>
            </table>


            <div class="confirm__actions">
                <button type="submit" class="confirm__button--submit">送信</button>

                <a href="{{ route('contact.form') }}" class="confirm__button--back">修正</a>
            </div>

        </form>
    </div>
@endsection
