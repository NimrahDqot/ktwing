<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SubModule;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Hash;

class SubModuleController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $manage_modules = SubModule::orderBy('created_at','desc')->select('id','name','key','route_name','module_id')->paginate(10);
        return view('admin.sub_module.view', compact('manage_modules'));
    }

    public function create() {
        $module = Module::orderBy('created_at','desc')->get();
        return view('admin.sub_module.create', compact('module'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $manage_module = new SubModule();
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required|unique:sub_modules,name',
            'key' => 'required|unique:sub_modules,key',
            'module_id' => 'required',
        ] ,[
            'module_id.required' => 'Please select module name.'
        ]);
        $data['key'] =   str_replace(" ", "_", $request->key) ?? null;
        $data['name'] =   str_replace("_", " ", $request->name) ?? null;
        $manage_module->fill($data)->save();
        return redirect()->route('admin_sub_manage_module_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $manage_module = SubModule::findOrFail($id);
        $module = Module::orderBy('created_at','desc')->get();
        return view('admin.sub_module.edit', compact('manage_module','module'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = SubModule::findOrFail($id);
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required|unique:sub_modules,name',
            'key' => 'required|unique:sub_modules,key',
            'module_id' => 'required',
        ]
        ,[
            'module_id.required' => 'Please select module name.'
        ]);
        $data['key'] =   str_replace(" ", "_", $request->key) ?? null;
        $data['name'] =   str_replace("_", " ", $request->name) ?? null;
        $manage_module->fill($data)->save();
        return redirect()->route('admin_sub_manage_module_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = SubModule::findOrFail($id);
        $manage_module->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
