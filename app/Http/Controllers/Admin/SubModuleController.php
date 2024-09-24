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
        $manage_module = SubModule::orderBy('created_at','desc')->get();
        $module = Module::orderBy('created_at','desc')->get();
        return view('admin.sub_module.admin_sub_module_view', compact('manage_module','module'));
    }

    public function create() {
        $module = Module::orderBy('created_at','desc')->get();
        return view('admin.sub_module.admin_sub_module_create', compact('module'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $manage_module = new SubModule();
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required',
        ]);
        $manage_module->fill($data)->save();
        return redirect()->route('admin_sub_manage_module_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $manage_module = SubModule::findOrFail($id);
        $module = Module::orderBy('created_at','desc')->get();
        return view('admin.sub_module.admin_sub_module_edit', compact('manage_module','module'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $manage_module = SubModule::findOrFail($id);
        $data = $request->only($manage_module->getFillable());

        $request->validate([
            'name' => 'required',
        ]);
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
