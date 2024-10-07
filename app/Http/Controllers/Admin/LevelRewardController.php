<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\LevelReward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class LevelRewardController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $level_rewards = LevelReward::orderBy('created_at','desc')->get();
        return view('admin.level_rewards.view', compact('level_rewards'));
    }
    public function create() {
        return view('admin.level_rewards.create');
    }
    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $level_reward = new LevelReward();
        $data = $request->only($level_reward->getFillable());

        $request->validate([
            'level_name'=>  'required|string|unique:level_rewards,level_name',
            'min_points'=> 'required',
            'max_points'=> 'required',
            'awards_amount'=> 'required',
            'awads_gifts'=> 'required',
            'awads_gifts_img'=> 'required',
            'status'=> 'required',
            'user_count' => 'numeric'
        ]);

        $rand_value = md5(mt_rand(11111111,99999999));
        $ext = $request->file('image')->extension();
        $final_name = $rand_value.'.'.$ext;
        $request->file('image')->move(public_path('uploads/level_rewards/'), $final_name);
        unset($data['image']);
        $data['image'] = $final_name;
        $level_reward->fill($data)->save();
        return redirect()->route('admin_banner_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $level_reward = LevelReward::findOrFail($id);
        return view('admin.level_rewards.edit', compact('level_reward'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $banner = LevelReward::findOrFail($id);
        $data = $request->only($banner->getFillable());

        $request->validate([
            'level_name'=>  'required|string|unique:level_rewards,level_name',
            'min_points'=> 'required',
            'max_points'=> 'required',
            'awards_amount'=> 'required',
            'awads_gifts'=> 'required',
            'awads_gifts_img'=> 'required',
            'status'=> 'required',
            'user_count' => 'numeric'
        ]);
        if($request->image){
            @unlink(public_path('uploads/banner/'.$request->image));
            $ext = $request->file('image')->extension();
            $rand_value = md5(mt_rand(11111111,99999999));
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/banner/'), $final_name);

            unset($data['image']);
            $data['image'] = $final_name;
        }
        $banner->fill($data)->save();
        return redirect()->route('admin_banner_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $level_reward = LevelReward::findOrFail($id);
        $level_reward->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }


public function change_status($id) {
    $event = LevelReward::find($id);
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
