<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'post_description',
        'publish_date',
        'user_id',
        'image_id'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, "image_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "post_id");
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, "likes", "post_id", "user_id")
                    ->withTimestamps();
    }
}