<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "images";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'file_name',
        'file_extension',
        'file_path'
    ];

    public function user()
    {
        return $this->hasOne(User::class, "profile_pic_id");
    }

    public function post()
    {
        return $this->hasOne(Post::class, "image_id");
    }
}