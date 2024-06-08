<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = "follows";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function followedUser()
    {
        return $this->belongsTo("User", "followed_user_id");
    }

    public function follower()
    {
        return $this->belongsTo("User", "follower_id");
    }
}