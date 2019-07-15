<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmedCart extends Model
{
    protected $primaryKey = 'confirmed_cart_id';
    protected $fillable = ['order_id','clock_id','qty'];


    public function clock(){
        return $this->hasOne('App\Clock', 'clock_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order','order_id', 'order_id');
    }


}
