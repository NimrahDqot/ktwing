<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;
use Hash;

class VillageController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $village = Village::orderBy('created_at')->with('events')->paginate(10);

        return view('admin.village.view', compact('village'));
    }

    public function create() {
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.village.create', compact('roles'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $village = new Village();
        $data = $request->only($village->getFillable());

        $request->validate([
            'name'=> 'required|string',
            'district'=> 'required',
            'population'=> 'nullable',
            'language'=> 'nullable',
            'contact'=> 'nullable|digits:10'
        ]);

        $village->fill($data)->save();
        return redirect()->route('admin_village_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $village = Village::findOrFail($id);
        $roles = Role::orderBy('created_at','desc')->get();
        return view('admin.village.edit', compact('village','roles'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $village = Village::findOrFail($id);
        $data = $request->only($village->getFillable());

        $request->validate([
            'name'=> 'required',
            'district'=> 'required',
            'population'=> 'nullable',
            'language'=> 'nullable',
            'contact' => [
                'nullable',
                'digits:10',
                Rule::unique('villages')->ignore($id),
            ],
        ]);
        $village->fill($data)->save();
        return redirect()->route('admin_village_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $village = Village::findOrFail($id);
        $village->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }


        public function change_status($id) {
            $customer = Village::find($id);
            if($customer->status == '1') {
                if(env('PROJECT_MODE') == 0) {
                    $message=env('PROJECT_NOTIFICATION');
                } else {
                    $customer->status = '0';
                    $message=SUCCESS_ACTION;
                    $customer->save();
                }
            } else {
                if(env('PROJECT_MODE') == 0) {
                    $message=env('PROJECT_NOTIFICATION');
                } else {
                    $customer->status = '1';
                    $message=SUCCESS_ACTION;
                    $customer->save();
                }
            }
            return response()->json($message);
        }

}
