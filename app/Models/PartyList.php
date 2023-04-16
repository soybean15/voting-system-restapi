<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Http\Traits\Imageable;

class PartyList extends Model
{
    use HasFactory,Imageable;
    protected $fillable = ['name','image'];

    public function candidates(){
        return $this->hasMany(Candidate::class);
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('images/partylist/' . $value);
        } else {
            return asset('images/default/independent-logo.png');
        }
    }


    public function getRawImageAttribute()
    {
        if ($this->attributes['image']) {
            $path = public_path('images/partylist/' . $this->attributes['image']);
           
            if(file_exists($path)){
               return $path;
            }
            return null ;
            
            
        } else {
            return null;
        }
    }


}
