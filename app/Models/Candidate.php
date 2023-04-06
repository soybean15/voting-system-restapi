<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'vote_count', 'image'];
    
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
    }

      
    public function partylist()
    {
        return $this->belongsTo(\App\Models\Partylist::class);
    }


  

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/candidates/' . $value);
        } else {
            return asset('images/default/default-user.png');
        }
    }

    public function getRawImageAttribute()
    {
        if ($this->attributes['image']) {
            $path = public_path('images/candidates/' . $this->attributes['image']);
           
            if(file_exists($path)){
               return $path;
            }
            return null ;
            
            
        } else {
            return null;
        }
    }


}
