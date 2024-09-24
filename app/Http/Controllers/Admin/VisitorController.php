<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class VisitorController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $visitors = Visitor::orderBy('created_at')->get();
        return view('admin.Visitor.view', compact('visitors'));
    }




    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $faq = Visitor::findOrFail($id);
        $faq->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

    public function change_status($id) {
        $event = Visitor::find($id);
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
