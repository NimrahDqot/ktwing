<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class WithdrawController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        return view('admin.withdraw.view');
    }

    public function create() {
        return view('admin.withdraw.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $withdraw = new Withdraw();
        $data = $request->only($withdraw->getFillable());

        $request->validate([
            'name' => 'required',
        ]);

        $withdraw->fill($data)->save();
        return redirect()->route('admin_withdraw_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $withdraw = Withdraw::findOrFail($id);
        return view('admin.withdraw.edit', compact('withdraw'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $withdraw = Withdraw::findOrFail($id);
        $data = $request->only($withdraw->getFillable());

        $request->validate([
            'name' => 'required',
        ]);

        $withdraw->fill($data)->save();
        return redirect()->route('admin_withdraw_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $withdraw = Withdraw::findOrFail($id);
        $withdraw->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
