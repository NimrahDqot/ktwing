<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class NotificationController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $notification = Notification::paginate(10);
        return view('admin.notification.view', compact('notification'));
    }


    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $notification = Notification::findOrFail($id);
        $notification->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }


public function change_status($id) {
    $event = Notification::find($id);
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
