<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "images";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne("User", "profile_pic_id");
    }

    public function post()
    {
        return $this->hasOne("Post", "image_id");
    }
}