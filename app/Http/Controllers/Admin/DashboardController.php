<?php
namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Admin;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Village;
use App\Models\Module;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $total_villages = Village::where('status', '1')->count();
        $total_volunteers = Volunteer::where('status', '1')->count();
        $total_completed_events = Event::where('event_status', 'Completed')->where('status', '1')->count();
        $total_upcoming_events = Event::where('event_status', 'Upcoming')->where('status', '1')->count();
        $total_pending_events = Event::where('event_status', 'Upcoming')->where('status', '1')->count();
        $modules = Module::with('subModules')->get();
        return view('admin.home', compact('total_villages','total_volunteers','total_completed_events','total_upcoming_events','total_pending_events','modules'));
    }
}
