<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bus extends Model
{
    protected $fillable = [
        'title', 'price', 'location', 'city', 'state', 'rank', 'landmark', 'description', 'image', 'references', 'status', 'display_options', 'busnumber','discount','slug','reference_mail'
    ];

    public function busesprice()
    {
        return $this->hasMany('App\Busesprice', 'buses_id');
    }

    public function getStatusAttribute()
    {
        switch($this->attributes['status']){
            case 1:
                $status = 'Available';
            break;
            case 2:
                $status = 'Sold Out';
            break;
            case 3:
                $status = 'Coming Soon';
            break;
        }
        return $status;
    }

    public function isAvailable($id)
    {
       $result = DB::table('buses')->where('id', $id)
            ->where('status', 1)->get()->toArray();
        if(count($result) >= 1)
            return true;
        else
            return false;
    }

    public function isSoldOut($id)
    {
        $result = DB::table('buses')
                    ->where('id', $id)
                    ->where('status', 2)->get()->toArray();
        if(count($result) >= 1)
            return true;
        else
            return false;
    } 

    public function isComingSoon($id)
    {
        $result = DB::table('buses')
                    ->where('id', $id)
                    ->where('status', 3)->get()->toArray();
        if(count($result) >= 1)
            return true;
        else
            return false;
    } 
}
