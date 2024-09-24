<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Hash;

class ModuleController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $manage_module = Module::orderBy('created_at','desc')->get();
        return view('admin.module.admin_module_view', compact('manage_module'));
    }

    public function create() {
        return view('admin.module.admin_module_create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = new Module();
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required',
            'key' => 'required',
        ]);
        $manage_module->fill($data)->save();
        return redirect()->route('admin_manage_module_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $manage_module = Module::findOrFail($id);
        return view('admin.module.admin_module_edit', compact('manage_module'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = Module::findOrFail($id);
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required',
            'key' => 'required',
        ]);
        $manage_module->fill($data)->save();
        return redirect()->route('admin_manage_module_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = Module::findOrFail($id);
        $manage_module->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
