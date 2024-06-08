<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = "userdata";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne("User", "userdata_id");
    }
}
