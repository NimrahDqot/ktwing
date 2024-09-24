<?php
namespace App\Http\Controllers\Admin;
use App\Models\Product;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth.admin:admin');
    }

    public function index() {
        $product = Product::orderBy('created_at','desc')->get();
        return view('admin.product.view', compact('product'));
    }

    public function create() {
        $product = Product::orderBy('created_at','desc')->get();
        return view('admin.product.create', compact('product'));
    }

    public function store(Request $request) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
         $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
        $product = new Product();
        $data = $request->only($product->getFillable());
        $rand_value = md5(mt_rand(11111111,99999999));
        $ext = $request->file('image')->extension();
        $file_name = $rand_value.'.'.$ext;
        $request->file('image')->move(public_path('uploads/products/'),$file_name);
        unset($data['image']);
        $data['image'] = $file_name;
        $product->fill($data)->save();
        return redirect()->route('admin_product_view')->with('success', SUCCESS_ACTION);
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $product = Product::findOrFail($id);
        $data = $request->only($product->getFillable());

        if ($request->image) {

            @unlink(public_path('uploads/products/'.$product->image));
            $rand_value = md5(mt_rand(11111111,99999999));
            $ext = $request->file('image')->extension();
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/products/'), $final_name);
            unset($data['image']);
            $data['image'] = $final_name;
        }
        $product->fill($data)->save();

        return redirect()->route('admin_product_view')->with('success', SUCCESS_ACTION);
    }

    public function destroy($id) {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $task = Product::findOrFail($id);
        $task->delete();
        return Redirect()->back()->with('success', SUCCESS_ACTION);
    }
}
