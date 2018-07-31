<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $fillable=['username','password','tel','money','jifen'];
}
