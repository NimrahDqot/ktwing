<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SubModule;
use App\Models\Module;
use App\Models\Task;
use App\Models\Role;
use App\Models\ModuleSubmoduleRole;
use App\Models\User;
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
        $task = Task::with(['modules', 'subModules'])->paginate(10);
        return view('admin.task.view', compact('task'));
    }

    public function create() {
        $sub_module = SubModule::orderBy('created_at','desc')->get();
        $module = Module::orderBy('created_at','desc')->get();
        $roles = Role::active()->orderBy('created_at','desc')->get();
        return view('admin.task.create', compact('sub_module','module','roles'));
    }

    public function store(Request $request)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        // Validate request
        $request->validate([
            'role_id' => 'required|unique:tasks,role_id',
            'module_id' => 'required|array',
            'module_id.*' => 'exists:modules,id', // Validate each module_id exists
            'sub_module_id' => 'nullable|array', // Allow sub_module_id to be null
            'sub_module_id.*' => 'exists:sub_modules,id', // Validate each sub_module_id exists
        ]);

        // Create a new task
        $task = new Task();
        $data = $request->only($task->getFillable());
        $data['module_id'] = json_encode($request['module_id']);
        $data['sub_module_id'] = isset($request['sub_module_id']) ? json_encode($request['sub_module_id']) : null;

        // Save the task
        $task->fill($data);
        $task->save();
        // Store module-submodule-role relationships
        foreach ($request->module_id as $moduleId) {
            // Initialize a flag to check if any valid submodules were found
            $validSubModuleFound = false;

            // Check if sub_module_id exists and is an array
            if ($request->filled('sub_module_id') && is_array($request->sub_module_id)) {
                foreach ($request->sub_module_id as $subModuleId) {
                    // Check if the submodule belongs to the module
                    $subModule = SubModule::find($subModuleId);
                    if ($subModule && $subModule->module_id == $moduleId) {
                        // Create the relationship entry for each valid submodule
                        ModuleSubmoduleRole::create([
                            'task_id' => $task->id,
                            'module_id' => $moduleId,
                            'sub_module_id' => $subModuleId, // Use the valid sub_module_id
                            'role_id' => $request->role_id,
                        ]);
                        $validSubModuleFound = true; // Mark that a valid submodule was found
                    }
                }
            }

            // If no valid submodule was found, create a relationship with null
            if (!$validSubModuleFound) {
                ModuleSubmoduleRole::create([
                    'task_id' => $task->id,
                    'module_id' => $moduleId,
                    'sub_module_id' => null, // Set to null if no valid submodule was found
                    'role_id' => $request->role_id,
                ]);
            }
        }

        return redirect()->route('admin_task_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id)
    {
        $role = Role::orderBy('created_at','desc')->get();
        $task = Task::orderBy('created_at','desc')->with(['modules', 'subModules'])->findOrFail($id);
        $module = Module::orderBy('created_at','desc')->get(); // Get all modules for selection
        $sub_module  = SubModule::orderBy('created_at','desc')->get(); // Get all submodule for selection

        return view('admin.task.edit', compact('task', 'module', 'sub_module','role'));
    }


    public function update(Request $request, $id)
{
    // Check if the project mode is enabled
    if (env('PROJECT_MODE') == 0) {
        return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
    }

    // Validate request
    $request->validate([
        'role_id' => [
            'required',
            Rule::unique('tasks')->ignore($id),
        ],
        'module_id' => 'required|array',
        'module_id.*' => 'exists:modules,id', // Validate each module_id exists
        'sub_module_id' => 'required|array',
        'sub_module_id.*' => 'exists:sub_modules,id', // Validate each sub_module_id exists
    ]);

    // Find the task to update
    $task = Task::findOrFail($id);
    $data = $request->only($task->getFillable());
    $data['module_id'] = json_encode($request['module_id']);
    $data['sub_module_id'] = json_encode($request['sub_module_id']) ?? null;

    // Update the task
    $task->fill($data);
    $task->save();

    // Clear existing module-submodule-role relationships
    ModuleSubmoduleRole::where('task_id', $task->id)->delete();

    // Store new module-submodule-role relationships
    foreach ($request->module_id as $moduleId) {
        // Initialize a flag to check if any valid submodules were found
        $validSubModuleFound = false;

        // Check if sub_module_id exists and is an array
        if ($request->filled('sub_module_id') && is_array($request->sub_module_id)) {
            foreach ($request->sub_module_id as $subModuleId) {
                // Check if the submodule belongs to the module
                $subModule = SubModule::find($subModuleId);
                if ($subModule && $subModule->module_id == $moduleId) {
                    // Create the relationship entry for each valid submodule
                    ModuleSubmoduleRole::create([
                        'task_id' => $task->id,
                        'module_id' => $moduleId,
                        'sub_module_id' => $subModuleId, // Use the valid sub_module_id
                        'role_id' => $request->role_id,
                    ]);
                    $validSubModuleFound = true; // Mark that a valid submodule was found
                }
            }
        }

        // If no valid submodule was found, create a relationship with null
        if (!$validSubModuleFound) {
            ModuleSubmoduleRole::create([
                'task_id' => $task->id,
                'module_id' => $moduleId,
                'sub_module_id' => null, // Set to null if no valid submodule was found
                'role_id' => $request->role_id,
            ]);
        }
    }

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
