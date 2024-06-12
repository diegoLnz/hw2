<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasaPost extends Model
{
    protected $table = "nasaposts";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'post_description',
        'publish_date',
        'image_id'
    ];

    public function nasaImage()
    {
        $this->belongsTo(NasaImage::class, "image_id");
    }
}