<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'FashionablyLate')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')

    {{-- ★★★ ここにモーダル関連のCSSを直接追加します ★★★ --}}
    <style>
        /* -------------------------------------
         * モーダル (ポップアップ) スタイル
         * (このスタイルは app.blade.php に直接記述し、他のCSSからの影響を最小限にする)
         * ------------------------------------- */

        /* モーダル背景: 画面全体を覆い、コンテンツを中央に固定表示する */
        .modal-overlay {
            display: none; /* 初期状態は非表示 */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1000; /* 他の要素より手前に表示させる */
            background-color: rgba(0, 0, 0, 0.6); /* 背景の半透明色 */
            justify-content: center;
            align-items: center; /* モーダルコンテンツを画面中央に配置 */
            overflow-y: hidden; /* スクロールバーが表示されないようにする */
        }

        /* JavaScriptでこのクラスが付与されたら表示 */
        .modal-overlay.is-active {
            display: flex;
        }

        /* モーダルコンテンツ: 画面中央に表示されるカード部分 */
        .modal-content {
            background-color: var(--color-background-card, #fefefe); /* common.cssの変数を使用 */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            transform: scale(0.95); /* アニメーション初期状態 */
            opacity: 0;
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }

        /* モーダル表示時のアニメーション */
        .modal-overlay.is-active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        /* 閉じるボタン (Xマーク) */
        .modal-close {
            color: var(--color-text-secondary, #aaa); /* common.cssの変数を使用 */
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: var(--color-text-primary, #000); /* common.cssの変数を使用 */
            text-decoration: none;
        }

        /* モーダル内の詳細テーブル */
        .modal-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-size: 14px;
        }

        .modal-table th {
            width: 35%;
            font-weight: bold;
            text-align: left;
            color: var(--color-accent-button, #6c5b52); /* common.cssの変数を使用 */
            padding: 10px 0;
            border-bottom: 1px dotted var(--color-border, #ccc); /* common.cssの変数を使用 */
            vertical-align: top;
        }

        .modal-table td {
            width: 65%;
            word-wrap: break-word;
            word-break: break-all;
            padding: 10px 0;
            border-bottom: 1px dotted var(--color-border, #ccc); /* common.cssの変数を使用 */
        }

        /* 削除ボタンのフォームとボタン */
        .modal-delete-form {
            text-align: center;
            margin-top: 30px;
        }

        .modal-delete-button {
            background-color: #A0522D; /* common.cssにない色なので直接指定 */
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: opacity 0.2s;
            font-weight: bold;
        }

        .modal-delete-button:hover {
            opacity: 0.8;
        }
    </style>
    {{-- ★★★ ここまでモーダル関連のCSS ★★★ --}}

</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__logo">ContactForm</h1>
            <nav class="header__nav">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav__button">logout</button>
                    </form>
                @else
                    @if (Route::currentRouteName() == 'register')
                        <a href="{{ route('login') }}" class="nav__button">login</a>
                    @elseif (Route::currentRouteName() == 'login')
                        <a href="{{ route('register') }}" class="nav__button">register</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    @yield('scripts')
</body>

</html>
