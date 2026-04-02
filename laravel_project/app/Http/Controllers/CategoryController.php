<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cate_arr = Category::all();
        return view('admin.category_management', ["cate_arr" => $cate_arr]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add_category');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
{       
    $table = new Category();
    $table->name = $request->category_name;

    if ($request->hasFile('category_image')) {

        $file = $request->file('category_image');
        $filename = time() . "_img." . $file->getClientOriginalExtension();
        $file->move('upload/category/', $filename);

        $table->image = $filename;
    } else {
        $table->image = null; // ya default image
    }

    $table->save();

    Alert::success('add-category successfully!');
    return back();
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // You can fill this later
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // You can fill this later
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // You can fill this later
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $category = category::find($id); // ya Model name

    if(!$category){
        Alert::error('Error', 'Category not found.');
        return back();
    }

    // agar image hai to delete kar lo
    if($category->image && file_exists(public_path('upload/category/'.$category->image))){
        unlink(public_path('upload/category/'.$category->image));
    }

    $category->delete();

    Alert::success('Deleted', 'Category deleted successfully.');
    return back();
}
}