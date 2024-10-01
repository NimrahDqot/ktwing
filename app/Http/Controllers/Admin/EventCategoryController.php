<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class EventCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $event_category = EventCategory::orderBy('created_at','desc')->get();

        $used_cat_ids  =Event::distinct()->pluck('event_category_id');
          return view('admin.event_category.view', compact('event_category','used_cat_ids'));
    }

    public function create() {
        return view('admin.event_category.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $event_category = new EventCategory();
        $data = $request->only($event_category->getFillable());

        $request->validate([
            'name' => 'required|unique:event_categories,name',
        ]);

        $event_category->fill($data)->save();
        return redirect()->route('admin_event_category_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $event_category = EventCategory::findOrFail($id);
        return view('admin.event_category.edit', compact('event_category'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $event_category = EventCategory::findOrFail($id);
        $data = $request->only($event_category->getFillable());

        $request->validate([
            'name' => [
                'required',
                Rule::unique('event_categories')->ignore($event_category->id),
            ],
        ]);

        $event_category->fill($data)->save();
        return redirect()->route('admin_event_category_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $event_category = EventCategory::findOrFail($id);
        $event_category->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function change_status($id) {
        $event = EventCategory::find($id);
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
