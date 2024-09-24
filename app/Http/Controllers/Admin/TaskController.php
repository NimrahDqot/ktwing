<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SubModule;
use App\Models\Module;
use App\Models\Task;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Hash;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $sub_module = SubModule::orderBy('created_at','desc')->get();
        $module = Module::orderBy('created_at','desc')->get();
        $role = Role::orderBy('created_at','desc')->get();
        $task = Task::with(['SubModule', 'Module'])->get();
        return view('admin.task.view', compact('sub_module','module','role','task'));
    }

    public function create() {
        $sub_module = SubModule::orderBy('created_at','desc')->get();
        $module = Module::orderBy('created_at','desc')->get();
        $role = Role::orderBy('created_at','desc')->get();
        return view('admin.task.create', compact('sub_module','module','role'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $task = new Task();
        $data = $request->except(['module_id', 'sub_module_id']);
        $task->fill($data);
        $task->save();
        if ($request->has('module_id')) {
            $task->Module()->sync($request->module_id);
        }

        if ($request->has('sub_module_id')) {
            $task->SubModule()->sync($request->sub_module_id);
        }
        // $request->validate([
        //     'role_id' => 'required',
        //     'module_id' => 'required',
        //     'sub_module_id' => 'required',
        // ]);
        // $task->fill($data)->save();
        return redirect()->route('admin_task_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $task = Task::findOrFail($id);
        $module = Module::orderBy('created_at','desc')->get();
        $role = Role::orderBy('created_at','desc')->get();
        $sub_module = SubModule::orderBy('created_at','desc')->get();

        return view('admin.task.edit', compact('sub_module','module','task','role'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $task = Task::findOrFail($id);
        $task->role_id = $request->role_id;
        $task->Module()->sync($request->module_id);
        $task->SubModule()->sync($request->sub_module_id);
        $task->save();

        // $request->validate([
        //     'role_id' => 'required',
        //     'module_id' => 'required',
        //     'sub_module_id' => 'required',
        // ]);
        return redirect()->route('admin_task_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $task = Task::findOrFail($id);
        $task->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
