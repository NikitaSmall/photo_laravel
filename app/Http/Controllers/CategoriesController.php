<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except(['index',  'show']);
    }

    public function index()
    {
      $categories = Category::all();
      return view('categories.index', [
        'categories' => $categories
      ]);
    }

    public function show(Request $request)
    {
      $category = Category::with('photos.user')->where('id', $request->id)->first();
      return view('categories.show', [
        'category' => $category
      ]);
    }

    public function create(Request $request)
    {
      $validator = $request->validate([
        'title' => 'required|unique:categories'
      ]);

      if ($validated->fails()) {
        return redirect(route('home')->withErrors($validator));
      }

      Category::create([
        'title' => $request->title
      ]);
      return redirect(route('home'));
    }
}
