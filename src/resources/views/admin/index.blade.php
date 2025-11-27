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
    }

    /* ページネーションのSVGアイコンのスタイル */
    .pagination-links svg.w-5.h-5 {
        /* 親要素のクラスも指定して詳細度を上げる */
        width: 20px;
        /* 少し小さく調整 */
        height: 20px;
        /* 色は後ほど.pagination-link-buttonで設定するため、ここでは指定しない */
    }

    /* ページネーションのアイコンの色をcommon.cssの変数から取得 */
    .pagination-links .pagination .page-item .page-link span {
        color: var(--color-accent-button);
        /* 数字の色 */
    }

    .pagination-links .pagination .page-item.active .page-link span {
        color: white;
        /* アクティブな数字の色 */
    }

    .pagination-links .pagination .page-item .page-link svg {
        fill: var(--color-accent-button);
        /* 矢印の色 */
    }

    .pagination-links .pagination .page-item.disabled .page-link span,
    .pagination-links .pagination .page-item.disabled .page-link svg {
        color: var(--color-text-secondary);
        /* 無効な矢印や数字の色 */
        fill: var(--color-text-secondary);
        opacity: 0.6;
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
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="search-form__date-input"> {{-- ★修正: クラス追加 --}}
                    {{-- date_to はスクリーンショットにないので一旦非表示のままで --}}
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
