<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
      'title', 'is_private', 'user_id'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function photos()
    {
      return $this->hasMany(Photo::class);
    }

    public function hasAccess($userId)
    {
      if ($this->isPublic()) {
        return true;
      }

      return $this->user_id == $userId;
    }

    public function isPublic()
    {
      return !$this->is_private;
    }

    public static function getPublic($userId)
    {
      $query = Category::where('is_private', false);

      return ($userId) ? $query->orWhere('user_id', $userId)->get() : $query->get();
    }
}
