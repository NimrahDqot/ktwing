<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TermItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class PageTermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin:admin');
    }

    public function edit()
    {
        $page_term = TermItem::where('id',1)->first();
        return view('admin.page_term', compact('page_term'));
    }

    public function update(Request $request)
    {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['name'] = $request->input('name');
        $data['detail'] = $request->input('detail');
        $data['status'] = $request->input('status');


        TermItem::where('id',1)->update($data);

        return redirect()->back()->with('success', SUCCESS_ACTION);

    }

}
