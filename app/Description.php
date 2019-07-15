<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $primaryKey = 'description_id';
    protected $fillable = ['description_name','clock_id', 'value_uk', 'value_ru'];
    public function clock()
    {
        return $this->belongsTo('App\Clock','clock_id', 'clock_id');
    }
}
