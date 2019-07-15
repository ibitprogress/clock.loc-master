<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClockImage extends Model
{
    protected $primaryKey = 'image_id';
    protected $fillable = ['clock_id','uuid'];

    public function clock()
    {
        return $this->belongsTo('App\Clock','clock_id', 'clock_id');
    }
}
