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
        $manage_admin = Admin::orderBy('created_at','desc')->paginate(10);
        return view('admin.manage_admin.view', compact('manage_admin'));
    }

    public function create() {
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.manage_admin.create', compact('roles'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_admin = new Admin();
        $data = $request->only($manage_admin->getFillable());

        $request->validate([
            'username' => 'required',
            'mobile' => 'required|digits:10|unique:admins,mobile',
            'email' => 'required|unique:admins,email',
            'role_id' => 'required',
            'password' => 'required|same:confirm_password',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Optional image validation
        ]);

        if($request->hasFile('image')){

            $rand_value = md5(mt_rand(11111111,99999999));
            $ext = $request->file('image')->extension();
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/admin_photos/'), $final_name);
            unset($data['image']);
            $data['image'] = $final_name;
        }
        $data['password'] = Hash::make($request->password);
        $manage_admin->fill($data)->save();
        return redirect()->route('admin_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $manage_admin = Admin::findOrFail($id);
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.manage_admin.edit', compact('manage_admin','roles'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_admin = Admin::findOrFail($id);
        $data = $request->only($manage_admin->getFillable());

        $request->validate([
            'username' => 'required',
            'role_id' => 'required',
            'password' => 'same:confirm_password',
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('admins')->ignore($id),
            ],
           'email' => [
                'nullable',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                Rule::unique('admins')->ignore($id), // Use the correct table
            ],
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Optional image validation
        ]);

        if($request->hasFile('image')){
        // dd($request->all());
        @unlink(public_path('uploads/admin_photos/'.$manage_admin->image)); // Unlink old image
            $rand_value = md5(mt_rand(11111111,99999999));
            $ext = $request->file('image')->extension();
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/admin_photos/'), $final_name);
            unset($data['image']);
            $data['image'] = $final_name;
        }

        $data['password'] = Hash::make($request->password);

        $manage_admin->fill($data)->save();
        return redirect()->route('admin_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_admin = Admin::findOrFail($id);
        $manage_admin->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
    public function activate_status($id) {
        $admin_status = Admin::find($id);
        if($admin_status->activation_status == '1') {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $admin_status->activation_status = '0';
                $message=SUCCESS_ACTION;
                $admin_status->save();
            }
        } else {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $admin_status->activation_status = '1';
                $message=SUCCESS_ACTION;
                $admin_status->save();
            }
        }
        return response()->json($message);
    }
    public function is_admin_status($id) {
        $admin_status = Admin::find($id);
        if($admin_status->is_admin == '1') {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $admin_status->is_admin = '0';
                $message=SUCCESS_ACTION;
                $admin_status->save();
            }
        } else {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $admin_status->is_admin = '1';
                $message=SUCCESS_ACTION;
                $admin_status->save();
            }
        }
        return response()->json($message);
    }
}
