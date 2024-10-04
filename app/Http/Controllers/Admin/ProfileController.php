<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Hash;
use Auth;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function profile() {
        $admin_data = Auth::user();
        return view('admin.profile_change', compact('admin_data'));
    }

    public function profile_update(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $admin_data = Auth::user();
        $obj = Admin::findOrFail($admin_data->id);
        $data = $request->only($obj->getFillable());
        $request->validate([
            'username' => 'required',
            'mobile' => 'required|min:10|max:10',
            'email' => [
            'required',
            'email',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            ],
        ],[
            'username.required' => ERR_NAME_REQUIRED,
            'email.required' => ERR_EMAIL_REQUIRED,
            'email.email' => ERR_EMAIL_INVALID
        ]);



        $obj->fill($data)->save();
        return redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function password() {
        return view('admin.password_change');
    }

    public function password_update(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $admin_data = Auth::user();
        $obj = Admin::findOrFail($admin_data->id);
        $data = $request->only($obj->getFillable());
        $request->validate([
            'password' => 'required',
            're_password' => 'required|same:password',
        ],[
            'password.required' => ERR_PASSWORD_REQUIRED,
            're_password.required' => ERR_RE_PASSWORD_REQUIRED,
            're_password.same' => ERR_PASSWORDS_MATCH
        ]);
        $data['password'] = Hash::make($request->password);
        unset($data['re_password']);
        $obj->fill($data)->save();
        return redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function photo() {
        $admin_data = Auth::user();
        return view('admin.photo_change', compact('admin_data'));
    }

    public function photo_update(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $admin_data = Auth::user();
        $obj = Admin::findOrFail($admin_data->id);
        $data = $request->only($obj->getFillable());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ],[
            'image.required' => ERR_PHOTO_REQUIRED,
            'image.image' => ERR_PHOTO_IMAGE,
            'image.mimes' => ERR_PHOTO_JPG_PNG_GIF,
            'image.max' => ERR_PHOTO_MAX
        ]);
        @unlink(public_path('uploads/admin_photos/'.$admin_data->image));
        $ext = $request->file('image')->extension();
        $rand_value = md5(mt_rand(11111111,99999999));
        $final_name = $rand_value.'.'.$ext;
        $request->file('image')->move(public_path('uploads/admin_photos/'), $final_name);
        $data['image'] = $final_name;
        $obj->fill($data)->save();
        return redirect()->back()->with('success', SUCCESS_ACTION);
    }


    public function banner() {
        $admin_data = Auth::user();
        return view('admin.banner_change', compact('admin_data'));
    }

    public function banner_update(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $id = $request->id;
        $obj = Banner::findOrFail($id);
        $data = $request->only($obj->getFillable());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'

        ],[
            'banner.required' => ERR_PHOTO_REQUIRED,
            'banner.image' => ERR_PHOTO_IMAGE,
            'banner.mimes' => ERR_PHOTO_JPG_PNG_GIF,
            'banner.max' => ERR_PHOTO_MAX
        ]);
        @unlink(public_path('uploads/user_photos/'.$obj->banner));
        $ext = $request->file('banner')->extension();
        $rand_value = md5(mt_rand(11111111,99999999));
        $final_name = $rand_value.'.'.$ext;
        $request->file('banner')->move(public_path('uploads/user_photos/'), $final_name);
        $data['banner'] = $final_name;
        $obj->fill($data)->save();
        return redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
