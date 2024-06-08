<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function userdata()
    {
        return $this->belongsTo("UserData", "userdata_id");
    }

    public function image()
    {
        return $this->belongsTo("Image", "profile_pic_id");
    }

    public function posts()
    {
        return $this->hasMany("Post", "user_id");
    }

    public function comments()
    {
        return $this->hasMany("Comment", "user_id");
    }

    public function likes()
    {
        return $this->hasMany("Like", "user_id");
    }

    public function followers()
    {
        return $this->hasMany("Follow", "followed_user_id");
    }

    public function followedUsers()
    {
        return $this->hasMany("Follow", "follower_id");
    }
}
