<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class RewardController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $reward = Reward::orderBy('created_at','desc')->get();
        return view('admin.reward.view', compact('reward'));
    }

    public function create() {
        return view('admin.reward.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $reward = new Reward();
        $data = $request->only($reward->getFillable());


        $reward->fill($data)->save();
        return redirect()->route('admin_reward_view')->with('success', SUCCESS_ACTION);
    }
}
