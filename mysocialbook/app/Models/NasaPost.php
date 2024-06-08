<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasaPost extends Model
{
    protected $table = "nasaposts";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function nasaImage()
    {
        $this->belongsTo("NasaImage", "image_id");
    }
}