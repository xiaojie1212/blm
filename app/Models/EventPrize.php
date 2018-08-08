<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPrize extends Model
{
    //
    public $fillable=['events_id','name','description','user_id'];
    public function event(){
        return $this->belongsTo(Event::class,'events_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
