<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use \App\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->except(['index']);
      $this->middleware('category.privacyCheck')->only(['show']);
    }

    public function index()
    {
      $weather = $this->getWeather('Odessa,ua', 'imperial', 'ru');
      $categories = Category::getPublic(Auth::id());

      return view('categories.index', [
        'categories' => $categories,
        'weather' => $weather->main
      ]);
    }

    public function show(Request $request)
    {
      $category = Category::with('photos.user')->where('id', $request->id)->firstOrFail();

      return view('categories.show', [
        'category' => $category
      ]);
    }

    public function create(Request $request)
    {
      $validator = $request->validate([
        'title' => 'required|unique:categories'
      ]);

      if (!is_array($validator) && $validator->fails()) {
        return redirect(route('home')->withErrors($validator));
      }

      Category::create([
        'title' => $request->title,
        'is_private' => $request->is_private,
        'user_id' => Auth::user()->id
      ]);

      return redirect(route('home'));
    }

    private function getWeather($city, $units = 'metric', $lang = 'en')
    {
      $res = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&units=' . $units . '&lang=' . $lang . '&appid=' . env('OPENWEATHER_API_KEY'));
      return json_decode($res);
    }
}
