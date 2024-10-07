<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Attendees;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class AttendeesController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $eventAttendeeIds = DB::table('events')
        ->pluck('attendees_id')
        ->flatMap(function ($ids) {
            return explode(',', $ids); // Split the comma-separated values into an array
        })
        ->unique() // Get unique IDs
        ->toArray(); // Convert to an array
    $attendees = Attendees::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.attendees.view', compact('attendees','eventAttendeeIds'));
    }

    public function create() {
        return view('admin.attendees.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $attendees = new Attendees();
        $data = $request->only($attendees->getFillable());

        $request->validate([
            'name' => 'required|string|max:39',
            'role' => 'required|string|max:39',
            'image' => 'nullable',
        ]);
        if($request->hasFile('image')){

            $rand_value = md5(mt_rand(11111111,99999999));
            $ext = $request->file('image')->extension();
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/attendees/'), $final_name);
            unset($data['image']);
            $data['image'] = $final_name;
        }
        $attendees->fill($data)->save();
        return redirect()->route('admin_attendees_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $attendees = Attendees::findOrFail($id);
        return view('admin.attendees.edit', compact('attendees'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $attendees = Attendees::findOrFail($id);
        $data = $request->only($attendees->getFillable());

        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);
        if($request->hasFile('image')){
            @unlink(public_path('uploads/attendees/'.$attendees->image)); // Unlink old image
            $ext = $request->file('image')->extension();
            $rand_value = md5(mt_rand(11111111,99999999));
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/attendees/'), $final_name);

            $data['image'] = $final_name; // Update with new image name
        }
        $attendees->fill($data)->save();
        return redirect()->route('admin_attendees_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $attendees = Attendees::findOrFail($id);
        $attendees->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function change_status($id) {
        $event = Attendees::find($id);
        if($event->status == '1') {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $event->status = '0';
                $message=SUCCESS_ACTION;
                $event->save();
            }
        } else {
            if(env('PROJECT_MODE') == 0) {
                $message=env('PROJECT_NOTIFICATION');
            } else {
                $event->status = '1';
                $message=SUCCESS_ACTION;
                $event->save();
            }
        }
        return response()->json($message);
    }

}
