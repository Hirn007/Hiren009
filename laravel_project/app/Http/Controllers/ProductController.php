<?php

namespace App\Http\Controllers;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
  {
     $prod_arr = product::all();
    return view('admin.product_management', ['prod_arr' => $prod_arr]);
  }

    public function create()
    {
        $cate_arr = category::all();
        return view('admin.add_product', ['cate_arr' => $cate_arr]);
    }

    public function getProducts($cat_id)
{
    $products = product::where('cate_id', $cat_id)->get();
    return response()->json($products);
}

    /**
     * Search products and show product listing page
     */
    public function search(Request $request)
{
    $query = $request->get('query', '');
    $category = $request->get('category', '');

    $products = product::when($query, function($q) use ($query) {
            return $q->where('name', 'like', '%'.$query.'%')
                     ->orWhere('description', 'like', '%'.$query.'%')
                     ->orWhere('brand', 'like', '%'.$query.'%');
        })
        ->when($category, function($q) use ($category) {
            return $q->where('cate_id', $category);
        })
        ->get();

    return view('website.product', compact('products', 'query'));
}

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query', '');

        if($query == '') {
            return response()->json([]);
        }

        $products = product::where('name', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%')
            ->orWhere('brand', 'like', '%'.$query.'%')
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Show single product detail page
     */
    public function productDetail($id)
{
    $product = product::findOrFail($id);
    return view('website.product', compact('product'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $table = new product();

    $table->cate_id = $request->cate_id;
    $table->name = $request->product_name;
    $table->brand = $request->brand;
    $table->price = $request->price;
    $table->description = $request->description;

    // IMAGE Upload
    $file = $request->file('image');
    $filename = time() . "_img." . $file->getClientOriginalExtension();
    $file->move('upload/product/', $filename);
    $table->image = $filename;

    $table->save();

    // ✅ SweetAlert call
    Alert::success('Success', 'Product Added Successfully');

    // Redirect back
    return redirect()->route('add_product');
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $data = product::find($id);

    if ($data->image && file_exists(public_path('upload/product/'.$data->image))) {
        unlink(public_path('upload/product/'.$data->image));
    }

    $data->delete();

    // ✅ SweetAlert call
    Alert::success('Deleted', 'Product Deleted Successfully');

    return back();
}
}
