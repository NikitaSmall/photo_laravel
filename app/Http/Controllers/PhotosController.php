<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Photo;

class PhotosController extends Controller
{
    const PHOTO_STORAGE = '/img/photos';
    const SITE_PUBLIC_PREFIX = '/';

    public function __construct()
    {
      $this->middleware('auth')->only(['create']);
    }

    public function index()
    {
      $photos = Photo::all();
      return view('photos.index', ['photos' => $photos]);
    }

    public function create(Request $request)
    {
      $validator = $request->validate([
        'photo' => 'file|image|required|size:2000'
      ]);

      if ($validator->fails()) {
        return redirect(route('category', $request->category_id))->withErrors($validator);
      }

      $file = $request->file('photo');
      $path = self::SITE_PUBLIC_PREFIX . $file->store(self::PHOTO_STORAGE);

      Photo::create([
        'path' => $path,
        'category_id' => $request->category_id,
        'user_id' => Auth::user()->id
      ]);

      return redirect(route('category', $request->category_id));
    }
}
