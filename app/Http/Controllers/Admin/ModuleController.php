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
        $manage_modules = Module::orderBy('created_at','desc')->select('id', 'name', 'key', 'route_name')->paginate(10);
        return view('admin.module.view', compact('manage_modules'));
    }

    public function create() {
        return view('admin.module.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = new Module();
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required|unique:modules,name',
            'key' => 'required|unique:modules,key',
        ]);
        $data['key'] =   str_replace(" ", "_", $request->key) ?? null;
        $data['name'] =   str_replace("_", " ", $request->name) ?? null;
        $manage_module->fill($data)->save();
        return redirect()->route('admin_manage_module_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $manage_module = Module::findOrFail($id);
        return view('admin.module.edit', compact('manage_module'));
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
        $data['key'] =   str_replace(" ", "_", $request->key) ?? null;
        $data['name'] =   str_replace("_", " ", $request->name) ?? null;
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
