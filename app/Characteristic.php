<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    protected $primaryKey = 'characteristic_id';
    protected $fillable = ['characteristic_name','clock_id', 'value'];
    public function clock()
    {
        return $this->belongsTo('App\Clock','clock_id', 'clock_id');
    }
}
