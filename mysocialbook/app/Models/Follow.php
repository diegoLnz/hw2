<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = "follows";
    protected $primaryKey = "id";
    public $timestamps = true;

    protected $fillable = [
        'follower_id',
        'followed_user_id',
        'created_at',
        'updated_at'
    ];

    public function followedUser()
    {
        return $this->belongsTo(User::class, "followed_user_id");
    }

    public function follower()
    {
        return $this->belongsTo(User::class, "follower_id");
    }
}