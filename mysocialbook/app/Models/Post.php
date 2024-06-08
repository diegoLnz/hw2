<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo("Image", "image_id");
    }

    public function user()
    {
        return $this->belongsTo("User", "user_id");
    }

    public function comments()
    {
        return $this->hasMany("Comment", "post_id");
    }

    public function likes()
    {
        return $this->hasMany("Like", "post_id");
    }
}