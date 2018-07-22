<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Cloudder;

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
        'photo' => 'file|image|required'
      ]);

      if (!is_array($validator) && $validator->fails()) {
        return redirect(route('category', $request->category_id))->withErrors($validator);
      }

      $file = $request->file('photo');

      $res = Cloudder::upload($file->getPathName(), null, [], []);

      Photo::create([
        'path' => $res->getResult()['url'],
        'public_id' => $res->getResult()['public_id'],
        'category_id' => $request->category_id,
        'user_id' => Auth::user()->id
      ]);

      return redirect(route('category', $request->category_id));
    }

    public function delete(Request $request)
    {
      Photo::deleteWithCloudder($request->id);
      return redirect(route('category', $request->category_id));
    }
}
