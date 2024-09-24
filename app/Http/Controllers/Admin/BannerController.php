<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class BannerController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $banner = Banner::orderBy('created_at')->get();
        return view('admin.banner_view', compact('banner'));
    }

    public function create() {
        return view('admin.banner_create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $banner = new Banner();
        $data = $request->only($banner->getFillable());

        $request->validate([
            'title' => 'required',
            'url' => 'nullable',
            'image' => 'required',
            'type' => 'nullable',
            'sort_by' => 'numeric'
        ]);

        $rand_value = md5(mt_rand(11111111,99999999));
        $ext = $request->file('image')->extension();
        $final_name = $rand_value.'.'.$ext;
        $request->file('image')->move(public_path('uploads/banner/'), $final_name);
        unset($data['image']);
        $data['image'] = $final_name;
        $banner->fill($data)->save();
        return redirect()->route('admin_banner_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $banner = Banner::findOrFail($id);
        return view('admin.banner_edit', compact('banner'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $banner = Banner::findOrFail($id);
        $data = $request->only($banner->getFillable());

        $request->validate([
            'title' => 'required',
            'url' => 'nullable',
            'image' => 'nullable',
            'type' => 'nullable',
            'sort_by' => 'numeric'
        ]);
        if($request->image){
            @unlink(public_path('uploads/banner/'.$request->image));
            $ext = $request->file('image')->extension();
            $rand_value = md5(mt_rand(11111111,99999999));
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/banner/'), $final_name);

            unset($data['image']);
            $data['image'] = $final_name;
        }
        $banner->fill($data)->save();
        return redirect()->route('admin_banner_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $banner = Banner::findOrFail($id);
        $banner->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }


}
