<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $roles = Role::orderBy('created_at', 'desc')->get();
        $used_role_ids = Volunteer::distinct()->pluck('role_id')->merge(Admin::distinct()->pluck('role_id'));

        return view('admin.role.view', compact('roles', 'used_role_ids'));
    }


    public function create() {
        return view('admin.role.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $role = new Role();
        $data = $request->only($role->getFillable());

        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role->fill($data)->save();
        return redirect()->route('admin_role_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $role = Role::findOrFail($id);
        $data = $request->only($role->getFillable());

        $request->validate([
         'name' => [
        'required',
        Rule::unique('roles')->ignore($id) // where $id is the ID of the role being updated
    ],

        ]);

        $role->fill($data)->save();
        return redirect()->route('admin_role_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $role = Role::findOrFail($id);
        $role->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function change_status($id){
        $role = Role::find($id);
        if($role->status == '1') {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $role->status = '0';
                $message=SUCCESS_ACTION;
                $role->save();
            }
        } else {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $role->status = '1';
                $message=SUCCESS_ACTION;
                $role->save();
            }
        }
        return response()->json($message);
    }
}
