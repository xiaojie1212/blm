<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    //
    public $fillable=[
        'user_id','name','tel',
        'province','city','area',
        'detail_address'
    ];
}
