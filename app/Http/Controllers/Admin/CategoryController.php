<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = Category::latest()->paginate(10);
    return view('admin.category.index', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
        'name' => 'required|string|unique:categories|max:255',
        'description' => 'nullable|string'
    ]);

    $category = new Category();
    $category->name = $request->name;
    $category->description = $request->description;
    $category->save();

    return response()->json(['success' =>true, 'message' => 'Category created']);
  }

  /**
   * Display the specified resource.
   *
   * @param \App\Models\Category $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    return response()->json($category);
  }

  public function paginate(Request $request) {
    return $request->ajax() ? Category::latest()->paginate(10) : abort(404);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Models\Category $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    $request->validate([
        'name' => 'required|string|unique:categories,name,'. $category->id . '|max:255',
        'description' => 'nullable|string'
    ]);

    $category->name = $request->name;
    $category->description = $request->description;
    $category->save();

    return response()->json(['success' =>true, 'message' => 'Category updated']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Models\Category $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    if(auth()->user()->hasRole('superadmin')) {
      $category->delete();
      return response()->json(['message' => 'Category deleted', 'success' => true]);
    }
    else {
      return response()->json(['success' => false, 'message' => 'You are not allowed to access this page'], 403);
    }
  }
}
