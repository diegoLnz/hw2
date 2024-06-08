<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasaImage extends Model
{
    protected $table = "nasaimages";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function nasaPost()
    {
        return $this->hasOne("NasaPost", "image_id");
    }
}