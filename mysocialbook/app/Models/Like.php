<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = "likes";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo("User", "user_id");
    }

    public function post()
    {
        return $this->belongsTo("Post", "post_id");
    }
}