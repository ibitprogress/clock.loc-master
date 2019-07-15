<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $fillable = ['client_first_name','client_last_name','phone','city','warehous','delivery_method','pay_method','total_price','revised'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i  |  d-m-Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('H:i  |  d-m-Y');
    }
    public function confirmedCart(){
        return $this->hasMany('App\ConfirmedCart', 'order_id');
    }
}
