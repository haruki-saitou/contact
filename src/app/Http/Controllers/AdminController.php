<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Contact::with('category');

        $query->nameOrEmailSearch($request->name);

        $query->genderSearch($request->gender);

        $query->categoryFilter($request->category_id);

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contacts = $query->paginate(5);

        return view('admin.index', compact('contacts', 'categories'));
    }
    public function export(Request $request)
    {
        $query = Contact::with('category');

        $query->nameOrEmailSearch($request->name);
        $query->genderSearch($request->gender);
        $query->categoryFilter($request->category_id);

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $contacts = $query->get();

        $csvHeader = [
            'ID', '姓', '名', '性別', 'メールアドレス', '電話番号',
            '住所', '建物名', 'カテゴリID', 'カテゴリ名', 'お問い合わせ詳細', '登録日時'
        ];

        $csvData = [];
        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->id,
                $contact->last_name,
                $contact->first_name,
                $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category_id,
                $contact->category->content,
                $contact->detail,
                $contact->created_at,
            ];
        }

        $csv = "\xEF\xBB\xBF" . implode(',', $csvHeader) . "\n";
        foreach ($csvData as $row) {

            $sanitizedRow = array_map(function($value) {
                return '"' . str_replace('"', '""', $value) . '"';
            }, $row);

            $csv .= implode(',', $sanitizedRow) . "\n";
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="contacts_export_' . date('Ymd_His') . '.csv"');
    }
        public function destroy(Contact $contact)
    {

        $contact->delete();

        return redirect()->route('admin.index')->with('success', 'お問い合わせ履歴を削除しました。');
    }
}
