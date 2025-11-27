{{-- admin/modal.blade.php --}}

<div class="modal-overlay" id="contactModal">
    <div class="modal-content">

        <span class="modal-close" id="modalClose">&times;</span>

        <table class="modal-table">
            <tr>
                <th>お名前</th>
                <td id="modal-name"></td>
            </tr>
            <tr>
                <th>性別</th>
                <td id="modal-gender"></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td id="modal-email"></td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td id="modal-tel"></td>
            </tr>
            <tr>
                <th>住所</th>
                <td id="modal-address"></td>
            </tr>
            <tr>
                <th>建物名</th>
                <td id="modal-building"></td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td id="modal-category"></td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td id="modal-detail"></td>
            </tr>
        </table>

        <form id="delete-form" method="POST" action="" class="modal-delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="modal-delete-button"
                onclick="return confirm('本当にこの問い合わせを削除しますか？\n削除すると元に戻せません。')">
                削除する
            </button>
        </form>
    </div>
</div>
