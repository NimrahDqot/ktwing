<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Hash;

class ManageAdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $manage_admin = Admin::orderBy('created_at','desc')->get();
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.manage_admin.manage_admin_view', compact('manage_admin','roles'));
    }

    public function create() {
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.manage_admin.manage_admin_create', compact('roles'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_admin = new Admin();
        $data = $request->only($manage_admin->getFillable());

        $request->validate([
            'username' => 'required',
            'usertype' => 'required',
            'password' => 'required|same:confirm_password',
        ]);
        $data['password'] = Hash::make($request->password);
        $manage_admin->fill($data)->save();
        return redirect()->route('admin_manage_admin_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $manage_admin = Admin::findOrFail($id);
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.manage_admin.manage_admin_edit', compact('manage_admin','roles'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_admin = Admin::findOrFail($id);
        $data = $request->only($manage_admin->getFillable());

        $request->validate([
            'username' => 'required',
            'usertype' => 'required',
            'password' => 'same:confirm_password',
        ]);
        $data['password'] = Hash::make($request->password);

        $manage_admin->fill($data)->save();
        return redirect()->route('admin_manage_admin_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_admin = Admin::findOrFail($id);
        $manage_admin->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
