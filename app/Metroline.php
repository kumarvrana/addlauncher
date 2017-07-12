<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metroline extends Model
{
    protected $fillable = ['line', 'slug', 'label', 'city'];

    public function metro()
    {
        return $this->hasMany('App\Metro', 'metroline_id');
    }
    
    public function getIdBySlug($slug)
    {
        $metroLine = Metroline::where('slug', $slug)->first();
        return $metroLine->id;
    }

    
}
