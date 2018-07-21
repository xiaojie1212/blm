<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //可修改字段
    public $fillable=['name','email','password','status','shop_id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
