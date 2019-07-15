<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    protected $primaryKey = 'clock_id';
    protected $fillable = ['name','gender','type_of_indexation', 'type_of_mechanism', 'producer','price','old_price','availability','hide', 'logo_uuid'];

    public function descriptions(){
        return $this->hasMany('App\Description', 'clock_id');
    }

    public function characteristics(){
        return $this->hasMany('App\Characteristic', 'clock_id');
    }

    public function functions(){
        return $this->hasOne('App\ClockFunction', 'clock_id');
    }

    public function clockImages(){
        return $this->hasMany('App\ClockImage', 'clock_id');
    }

    public function confirmedCart()
    {
        return $this->belongsTo('App\ConfirmedCart','clock_id', 'clock_id');
    }

    public function scopeFilter($query, $parameters){
        if (isset($parameters['gender'])) $query = $query->whereIn('gender', $parameters['gender']);
        if (isset($parameters['typeOfIndexation'])) $query = $query->whereIn('type_of_indexation', $parameters['typeOfIndexation']);
        if (isset($parameters['minPrice'])) $query = $query->where('price', '>', $parameters['minPrice']);
        if (isset($parameters['maxPrice'])) $query = $query->where('price', '<', $parameters['maxPrice']);
//        if (isset($parameters['style'])) $query = $query->characteristics()->whereIn('characteristic_name', $parameters['style']);
        if (isset($parameters['style'])){
            $data = $parameters['style'];
            $query = $query->whereHas('characteristics', function ($q) use ($data) {
                $q->whereIn('value', $data);
            });
        };
        if (isset($parameters['bodyMaterial'])){
            $data = $parameters['bodyMaterial'];
            $query = $query->whereHas('characteristics', function ($q) use ($data) {
                $q->whereIn('value', $data);
            });
        };
        if (isset($parameters['strapMaterial'])){
            $data = $parameters['strapMaterial'];
            $query = $query->whereHas('characteristics', function ($q) use ($data) {
                $q->whereIn('value', $data);
            });
        };
        return $query;
    }
}
