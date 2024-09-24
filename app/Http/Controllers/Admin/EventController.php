<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Village;
use App\Models\Volunteer;
use App\Models\Attendees;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class EventController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $event = Event::orderBy('created_at','desc')->get();
        $event_category = EventCategory::orderBy('created_at','desc')->get();
        $villages = Village::orderBy('created_at','desc')->get();
        $attendees = Attendees::orderBy('created_at','desc')->get();
        $volunteers = Volunteer::orderBy('created_at','desc')->get();
        return view('admin.event.view', compact('event','event_category','villages','attendees','volunteers'));
    }

    public function create() {
        $event_category = EventCategory::orderBy('created_at','desc')->get();
        $villages = Village::orderBy('created_at','desc')->get();
        $attendees = Attendees::orderBy('created_at','desc')->get();
          return view('admin.event.create', compact('event_category','villages','attendees'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $event = new Event();
        $data = $request->only($event->getFillable());

        $request->validate([
            'event_category_id' => 'required',
            'name' => 'required|string|max:250',
            'description' => 'required|string|max:250',
            'village_id' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'event_duration' => 'required',
            'event_agenda' => 'required',
            'expected_attendance' => 'required',
            'resoure_list' => 'required',
            'attendees_id' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Optional image validation
        ]);

        if($request->hasFile('image')){

            $rand_value = md5(mt_rand(11111111,99999999));
            $ext = $request->file('image')->extension();
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/event/'), $final_name);
            unset($data['image']);
            $data['image'] = $final_name;
        }
        $data['attendees_id'] = implode(',', $request->attendees_id);
        $event->fill($data)->save();
        return redirect()->route('admin_event_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $event = Event::findOrFail($id);
        $event_category = EventCategory::orderBy('created_at','desc')->get();
        $villages = Village::orderBy('created_at','desc')->get();
        $attendees = Attendees::orderBy('created_at','desc')->get();
        return view('admin.event.edit', compact('event','event_category','villages','attendees'));

    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $event = Event::findOrFail($id);
        $data = $request->only($event->getFillable());


        $request->validate([
            'event_category_id' => 'required',
            'name' => 'required|string|max:250',
            'description' => 'required|string|max:250',
            'village_id' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'event_duration' => 'required',
            'event_agenda' => 'required',
            'expected_attendance' => 'required',
            'resoure_list' => 'required',
            'attendees_id' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Optional image validation
        ]);

        if($request->hasFile('image')){
            @unlink(public_path('uploads/event/'.$event->image)); // Unlink old image
            $ext = $request->file('image')->extension();
            $rand_value = md5(mt_rand(11111111,99999999));
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/event/'), $final_name);
            $data['image'] = $final_name; // Update with new image name
        }
        $data['attendees_id'] = implode(',', $request->attendees_id);
        $event->fill($data)->save();
        return redirect()->route('admin_event_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $event = Event::findOrFail($id);
        $event->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function change_status($id) {
        $event = Event::find($id);
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
    // public function submit_volunteer(Request $request) {

    //     $request->validate([
    //         'id' => 'required|exists:events,id', // Validate that the ID exists
    //         'volunteer_id' => 'required|array', // Ensure volunteer IDs are sent as an array
    //     ]);
    //     $id = $request->id;
    //     $volunteer_id = $request->volunteer_id;
    //     $event = Event::find($id);;
    //     if (!$volunteer_id) {
    //         return response()->json(['error' => 'Record not found.'], 404);
    //     }
    //     $event->volunteer_id = implode(',', $volunteer_id); // Store as comma-separated values (if required)
    //     $event->save();

    //     return response()->json(['success' => true,
    //     'message' => 'Volunteers assigned successfully.',
    //     'assignedVolunteers' => $assignedVolunteers]);
    // }
    public function assign_volunteer(Request $request) {

        // Validate incoming request
        $request->validate([
            'id' => 'required|exists:events,id', // Validate that the ID exists
            'volunteer_id' => 'required|array', // Ensure volunteer IDs are sent as an array
        ]);

        $id = $request->id;
        $volunteer_id = $request->volunteer_id;

        // Find the event
        $event = Event::find($id);

        if (!$volunteer_id) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        // Save volunteer IDs as comma-separated values
        $event->volunteer_id = implode(',', $volunteer_id);
        $event->save();

        // Fetch the assigned volunteers after saving
        $assignedVolunteers = Volunteer::whereIn('id', $volunteer_id)->get(); // Assuming you have a Volunteer model

        return response()->json([
            'success' => true,
            'message' => 'Volunteers assigned successfully.',
            'assignedVolunteers' => $assignedVolunteers // Send the assigned volunteers in the response
        ]);
    }

    public function storeAttendee(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

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
        return response()->json([
            'success' => true,
            'message' => 'Attendee created successfully.',
            'attendee' => [
                'id' => $attendees->id,
                'name' => $attendees->name,
            ],
        ]);

    }

    public function assign_attendee(Request $request) {

        // Validate incoming request
        $request->validate([
            'id' => 'required|exists:events,id', // Validate that the ID exists
            'attendees_id' => 'required|array', // Ensure volunteer IDs are sent as an array
        ]);

        $id = $request->id;
        $attendees_id = $request->attendees_id;

        // Find the event
        $event = Event::find($id);

        if (!$attendees_id) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        // Save volunteer IDs as comma-separated values
        $event->attendees_id = implode(',', $attendees_id);
        $event->save();

        return response()->json([
            'success' => true,
            'message' => 'Attendees assigned successfully.',

        ]);
    }
}
