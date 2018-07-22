<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    public static $userStatus=['1'=>'启用','0'=>'禁用'];
    //可修改字段
    public $fillable=['name','email','password','status','shop_id'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
