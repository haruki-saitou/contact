<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'last_name'   => ['required', 'string', 'max:8'],
            'first_name'  => ['required', 'string', 'max:8'],

            'gender'      => ['required', 'integer', 'in:1,2,3'],

            'email'       => ['required', 'email', 'string', 'max:255'],

            'tel1'       => ['required', 'numeric', 'digits_between:1,5'],
            'tel2'       => ['required', 'numeric', 'digits_between:1,5'],
            'tel3'       => ['required', 'numeric', 'digits_between:1,5'],

            'address'     => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],

            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'detail'      => ['required', 'string', 'max:120'],
        ];
    }

    public function messages()
    {
        return [

            'last_name.required' => '姓を入力してください',
            'last_name.max' => '姓は8文字以内で入力してください',
            'last_name.string' => '姓は文字で入力してください',
            'first_name.required' => '名を入力してください',
            'first_name.max' => '名は8文字以内で入力してください',
            'first_name.string' => '名は文字で入力してください',

            'gender.required' => '性別を選択してください',

            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.unique' => '入力されたメールアドレスは既に登録されています',
            'email.max' => 'メールアドレスは255文字以内で入力してください',

            'tel_1.required' => '電話番号を入力してください',
            'tel_2.required' => '電話番号を入力してください',
            'tel_3.required' => '電話番号を入力してください',

            'tel_1.numeric' => '電話番号は半角英数字で入力してください',
            'tel_2.numeric' => '電話番号は半角英数字で入力してください',
            'tel_3.numeric' => '電話番号は半角英数字で入力してください',

            'tel_1.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel_2.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel_3.digits_between' => '電話番号は5桁まで数字で入力してください',

            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字で入力してください',
            'address.max' => '住所は255文字以内で入力してください',

            'category_id.required' => 'お問い合わせの種類を選択してください',

            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.string' => 'お問い合わせ内容は文字で入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',

        ];
    }
}