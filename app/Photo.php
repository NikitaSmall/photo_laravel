<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
      'path', 'category_id', 'user_id', 'public_id'
    ];

    public static function deleteWithCloudder($photoId)
    {
      $photo = self::find($photoId);
      Cloudder::delete($photo->public_id, []);

      $photo->delete();
    }

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
