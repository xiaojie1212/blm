<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable
{
    //
    //可修改字段
    public $fillable=['name','email','password'];

    //引入
    use HasRoles;
    protected $guard_name = 'admin';
}
