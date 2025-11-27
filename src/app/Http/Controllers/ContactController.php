<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;


class ContactController extends Controller
{

    public function contact()
    {
        $categories = Category::all();
        $input = session('form_input');
        session()->forget('form_input');
        return view('contents.contact', compact
        ('categories', 'input'));
    }

    public function confirm(ContactRequest $request)
    {
        $input = $request->validated();
        session(['form_input' => $input]);
        $category = Category::find($input['category_id']);
        return view('contents.confirm', compact('input', 'category'));
    }

    public function send(ContactRequest $request)
    {
        $input = $request->session()->get('form_input');
        if (!$input) {
            return redirect()->route('contact.form');
        }
        $input['tel'] = $input['tel1'] . $input['tel2'] . $input['tel3'];
        unset($input['tel1'], $input['tel2'], $input['tel3']);
        Contact::create($input);
        $request->session()->forget('form_input');
        return redirect()->route('contact.thanks');
    }

    public function thanks()
    {
        return view('contents.thanks');
    }

}