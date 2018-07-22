<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public static $statusArray=['1'=>'正常','0'=>'待审核',"-1"=>'已禁用'];
    //
    public $fillable=['shop_category_id','shop_name','img',
        'brand','on_time','fengniao','bao','piao','zhun',
        'start_send','send_cost','notice','discount'];
    public function shop_category()
    {
        return $this->belongsTo(ShopCategory::class);
    }
}
