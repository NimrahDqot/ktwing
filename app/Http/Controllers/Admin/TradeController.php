<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class TradeController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        return view('admin.trade.view');
    }

    public function create() {
        return view('admin.trade.create');
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data = $request->only($trade->getFillable());


        $trade->fill($data)->save();
        return redirect()->route('admin_trade_view')->with('success', SUCCESS_ACTION);
    }
}
