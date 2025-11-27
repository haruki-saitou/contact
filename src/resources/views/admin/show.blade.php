@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="admin__show-wrapper">
        <h2 class="admin__title">お問い合わせ詳細</h2>

        <div class="detail-card">
            <div class="detail-item">
                <strong>お名前:</strong>
                <span>{{ $contact->last_name }} {{ $contact->first_name }}</span>
            </div>

            <div class="detail-item">
                <strong>性別:</strong>
                <span>
                    @if ($contact->gender == 1) 男性
                    @elseif($contact->gender == 2) 女性
                    @else その他
                    @endif
                </span>
            </div>

            <div class="detail-item">
                <strong>メールアドレス:</strong>
                <span>{{ $contact->email }}</span>
            </div>

            <div class="detail-item">
                <strong>電話番号:</strong>
                <span>{{ $contact->tel }}</span>
            </div>

            <div class="detail-item">
                <strong>住所:</strong>
                <span>{{ $contact->address }}</span>
            </div>

            <div class="detail-item">
                <strong>建物名:</strong>
                <span>{{ $contact->building }}</span>
            </div>

            <div class="detail-item">
                <strong>お問い合わせの種類:</strong>
                <span>{{ $contact->category->content }}</span>
            </div>

            <div class="detail-item">
                <strong>お問い合わせ内容:</strong>
                <p>{{ $contact->detail }}</p>
            </div>

            <div class="detail-item">
                <strong>登録日時:</strong>
                <span>{{ $contact->created_at->format('Y/m/d H:i:s') }}</span>
            </div>
        </div>

        <a href="{{ route('admin.index') }}" class="back__button">一覧に戻る</a>
    </div>
@endsection
