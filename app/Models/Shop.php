<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    public $fillable=['shop_category_id','shop_name','img',
        'brand','on_time','fengniao','bao','piao','zhun',
        'start_send','send_cost'];
    public function shop_category()
    {
        return $this->belongsTo(ShopCategory::class);
    }
}
