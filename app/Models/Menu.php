<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    public $fillable=[
        'goods_name','shop_id','category_id','goods_price',
        'description','month_sales','tips','goods_img','status'
    ];
    public function menucate()
    {
        return $this->belongsTo(MenuCategories::class,'category_id');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
