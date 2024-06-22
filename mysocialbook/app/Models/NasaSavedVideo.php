<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasaSavedVideo extends Model
{
    protected $table = "nasasavedvideos";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'video_path',
        'user_id'
    ];

    public function user()
    {
        $this->belongsTo(User::class, "user_id");
    }
}