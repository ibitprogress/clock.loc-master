<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClockFunction extends Model
{
    protected $primaryKey = 'function_id';
    protected $fillable = ['clock_id', 'value_uk', 'value_ru'];
    public function clock()
    {
        return $this->belongsTo('App\Clock','clock_id', 'clock_id');
    }
}
