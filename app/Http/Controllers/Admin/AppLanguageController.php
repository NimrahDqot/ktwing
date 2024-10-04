<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AppLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Auth;

class AppLanguageController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $language_data = AppLanguage::orderBy('id', 'desc')->get();
        return view('admin.app_language.view', compact('language_data'));
    }

    public function create() {
        return view('admin.app_language.create');
    }



    public function edit($id) {
        $app_language = AppLanguage::findOrFail($id);
        return view('admin.app_language.edit', compact('app_language'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $app_language = new AppLanguage();
        $data = $request->only($app_language->getFillable());

        $request->validate([
            'lang_key' => 'required|string|unique:app_panel_texts|max:250',
            'lang_value' => 'required|string|unique:app_panel_texts|string',
        ]);
        $data['lang_key'] =   str_replace(" ", "_", $request->lang_key) ?? null;
        $app_language->fill($data)->save();

        // return redirect()->back();
        return redirect()->route('admin_app_language_view')->with('success', SUCCESS_ACTION);
    }


    public function update(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $i=0;
        foreach(request('lang_id') as $value) {
            $arr1[$i] = $value;
            $i++;
        }
        $i=0;
        foreach(request('lang_key') as $value){
            $arr2[$i] = $value;
            $i++;
        }
        $i=0;
        foreach(request('lang_value') as $value){
            $arr3[$i] = $value;
            $i++;
        }
        for($i=0;$i<count($arr1);$i++){
            $data = array();
            $data['lang_value'] = $arr3[$i];
            AppLanguage::where('id', $arr1[$i])->update($data);
        }
        return redirect()->back()->with('success', SUCCESS_ACTION);
    }
    public function update_single(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $app_language = AppLanguage::findOrFail($id);
        $data = $request->only($app_language->getFillable());

        $request->validate([
            'lang_value' => 'required|string',
        ]);


        $app_language->fill($data)->save();
        return redirect()->route('admin_app_language_view')->with('success', SUCCESS_ACTION);
    }



    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $app_language = AppLanguage::findOrFail($id);
        $app_language->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }

}
