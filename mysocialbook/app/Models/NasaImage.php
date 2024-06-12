<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasaImage extends Model
{
    protected $table = "nasaimages";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'network_path'
    ];

    public function nasaPost()
    {
        return $this->hasOne(NasaPost::class, "image_id");
    }
}