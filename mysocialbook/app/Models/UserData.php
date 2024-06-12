<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = "userdata";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'name_surname',
        'email'
    ];

    public function user()
    {
        return $this->hasOne(User::class, "userdata_id");
    }
}
