@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

{{-- pagination の svg スタイルはここに残しておきます --}}
<style>
    /* common.cssの変数をここでも使えるようにする */
    :root {
        --color-accent-button: #827E78;
        --color-accent-button-hover: #6c6963;
        --color-background-primary: #EDEBE9;
        --color-background-card: #FFFFFF;
        --color-text-primary: #333333;
        --color-text-secondary: #888888;
        --color-border: #DDDDDD;
        /* index.cssのカスタムプロパティ */
        --color-search-bg: #ffffff;
        --color-search-input-bg: #f4f4f4;
        --color-search-border: #e0e0e0;
        --color-search-button-search: #827e78;
        --color-search-button-reset: #b4a999;
        --color-export-button: #b4a999;
        --color-table-header-bg: #827e78;
        --color-table-row-hover: #f8f8f8;
        --color-detail-button: #b4a999;
    }

    /* ページネーションのSVGアイコンのスタイル */

    /* Laravel標準のページネーション出力全体 (navタグ) に適用 */
    .pagination-links nav {
        display: flex;
        justify-content: flex-end; /* ページネーション全体を右寄せ */
        align-items: center;
        width: 100%;
    }

    /* "Showing 1 to 5 of 37 results" の部分を非表示 (Tailwindのデフォルト出力に依存) */
    .pagination-links nav > div:first-child {
        display: none;
    }

    /* ページネーションのリンクを囲む要素 (数字と前後のボタン) に適用 */
    .pagination-links nav > div:last-child {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    /* リンクの各要素 (aタグまたはspanタグ) */
    .pagination-links a,
    .pagination-links span {
        display: flex;
        justify-content: center;
        align-items: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        margin: 0 2px;
        border: 1px solid var(--color-border);
        border-radius: 5px;
        color: var(--color-accent-button);
        background-color: var(--color-background-card);
        text-decoration: none;
        transition: background-color 0.2s, color 0.2s, border-color 0.2s;
        font-size: 14px;
        box-sizing: border-box; /* パディングとボーダーを幅・高さに含める */
    }

    /* ホバー時のスタイル */
    .pagination-links a:hover {
        background-color: var(--color-background-primary);
        border-color: var(--color-accent-button);
        color: var(--color-accent-button);
    }

    /* アクティブなページ (spanタグになることが多い) */
    .pagination-links span[aria-current="page"],
    .pagination-links a:focus { /* フォーカス時のスタイル (Tailwindで付与されることも考慮) */
        background-color: var(--color-accent-button);
        color: white;
        border-color: var(--color-accent-button);
        font-weight: bold;
    }

    /* 無効なリンク (spanタグになることが多い) */
    .pagination-links span:not([aria-current="page"]) {
        color: var(--color-text-secondary);
        cursor: not-allowed;
        background-color: #f0f0f0;
        border-color: #ddd;
    }

    /* SVGアイコンのスタイル */
    .pagination-links svg.w-5.h-5 {
        width: 16px;
        height: 16px;
        /* fillはaタグやspanタグのcolorプロパティを参照することが多いため、ここではfillを直接指定 */
        fill: var(--color-accent-button);
    }

    /* 無効なリンク内のSVGアイコンの色 */
    .pagination-links span:not([aria-current="page"]) svg.w-5.h-5 {
        fill: var(--color-text-secondary);
    }

    /* "前へ" "次へ" のボタンのスタイル調整 */
    .pagination-links a[rel="prev"],
    .pagination-links a[rel="next"] {
        padding: 0 12px;
    }

    /* "前へ" "次へ" のテキスト (Tailwindのデフォルト出力に依存) */
    .pagination-links a[rel="prev"] > span,
    .pagination-links a[rel="next"] > span {
        margin: 0 4px;
    }

</style>

@section('content')
    <script>
        window.contactDataList = @json($contacts->keyBy('id'));
        console.log('window.contactDataList loaded:', Object.keys(window.contactDataList).length, 'items');
    </script>

    <div class="admin__wrapper">
        <h2 class="admin__title">Admin</h2>

        <div class="search-form__container"> {{-- ★追加: 検索フォーム全体を囲むコンテナ --}}
            <form action="{{ route('admin.index') }}" method="GET" class="search-form__inner"> {{-- ★修正: formにクラス追加 --}}
                <div class="search-form__row"> {{-- ★追加: 検索入力フィールドの行 --}}
                    <input type="text" name="name" placeholder="名前やメールアドレスを入力してください" value="{{ request('name') }}"
                        class="search-form__input"> {{-- ★修正: クラス追加 --}}
                    <select name="gender" class="search-form__select"> {{-- ★修正: クラス追加 --}}
                        <option value="" @if (request('gender') == '') selected @endif>性別</option>
                        <option value="1" @if (request('gender') == '1') selected @endif>男性</option>
                        <option value="2" @if (request('gender') == '2') selected @endif>女性</option>
                        <option value="3" @if (request('gender') == '3') selected @endif>その他</option>
                    </select>
                    <select name="category_id" class="search-form__select"> {{-- ★修正: クラス追加 --}}
                        <option value="" @if (request('category_id') == '') selected @endif>お問い合わせの種類</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (request('category_id') == $category->id) selected @endif>
                                {{ $category->content }}
                            </option>
                        @endforeach
                    </select>
                    {{-- 日付入力フィールドを1つにまとめ、開始日のみ表示 (画像に合わせて) --}}
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="search-form__date-input"> {{-- ★修正: クラス追加 --}}
                    {{-- date_to はスクリーンショットにないので非表示のまま --}}
                    <input type="date" name="date_to" value="{{ request('date_to') }}" style="display:none;"
                        class="search-form__date-input">
                </div>
                <div class="search-form__buttons"> {{-- ★追加: 検索・リセットボタンの行 --}}
                    <button type="submit" class="search-form__button search-form__button--search">検索</button>
                    {{-- ★修正: クラス追加 --}}
                    <a href="{{ route('admin.index') }}" class="search-form__button search-form__button--reset">リセット</a>
                    {{-- ★修正: クラス追加 --}}
                </div>
            </form>
        </div>

        <div class="admin__actions"> {{-- ★修正: ボタンをまとめるコンテナ --}}
            <a href="{{ route('admin.export', request()->query()) }}" class="admin__button admin__button--export">
                {{-- ★修正: クラス変更 --}}
                エクスポート
            </a>
            <div class="pagination-links">
                {{ $contacts->appends(request()->query())->links() }}
            </div>
        </div>

        <div class="contact-list">
            <table>
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->last_name }}{{ $contact->first_name }}</td>
                            <td>
                                @if ($contact->gender == 1)
                                    男性
                                @elseif($contact->gender == 2)
                                    女性
                                @else
                                    その他
                                @endif
                            </td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->category->content }}</td>
                            <td>
                                <button class="modal-open-btn contact-list__detail-button" data-id="{{ $contact->id }}">
                                    {{-- ★修正: クラス追加 --}}
                                    詳細
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('admin.modal')
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalOverlay = document.getElementById('contactModal');
            const modalCloseBtn = document.getElementById('modalClose');
            const deleteForm = document.getElementById('delete-form');
            const deleteRouteTemplate = '{{ route('admin.destroy', ['contact' => 'CONTACT_ID_PLACEHOLDER']) }}';

            function getGenderString(genderValue) {
                const val = Number(genderValue);
                switch (val) {
                    case 1:
                        return '男性';
                    case 2:
                        return '女性';
                    case 3:
                        return 'その他';
                    default:
                        return '不明';
                }
            }

            function openModal(contactId) {
                const data = window.contactDataList[contactId];
                if (!data) {
                    console.error('エラー: 該当するID (' + contactId + ') の連絡先データが見つかりません。');
                    return;
                }
                if (!modalOverlay) {
                    console.error('エラー: モーダルのオーバーレイ要素 (id="contactModal") が見つかりません。');
                    return;
                }

                document.getElementById('modal-name').textContent = (data.last_name || '') + ' ' + (data
                    .first_name || '');
                document.getElementById('modal-gender').textContent = getGenderString(data.gender);
                document.getElementById('modal-email').textContent = data.email || '';
                document.getElementById('modal-tel').textContent = data.tel || '';
                document.getElementById('modal-address').textContent = data.address || '';
                document.getElementById('modal-building').textContent = data.building || 'N/A';
                document.getElementById('modal-category').textContent = (data.category && data.category.content) ?
                    data.category.content : '未分類';
                document.getElementById('modal-detail').textContent = data.detail || '';

                if (deleteForm) {
                    deleteForm.action = deleteRouteTemplate.replace('CONTACT_ID_PLACEHOLDER', data.id);
                }

                modalOverlay.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                if (modalOverlay) {
                    modalOverlay.classList.remove('is-active');
                    document.body.style.overflow = '';
                }
            }

            const openButtons = document.querySelectorAll('.modal-open-btn');
            openButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const contactId = this.getAttribute('data-id');
                    openModal(contactId);
                });
            });

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', closeModal);
            }

            if (modalOverlay) {
                modalOverlay.addEventListener('click', function(e) {
                    if (e.target === modalOverlay) {
                        closeModal();
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modalOverlay && modalOverlay.classList.contains('is-active')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
