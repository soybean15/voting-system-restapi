<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Http\Traits\Imageable;



class Candidate extends Model
{
    use HasFactory, Imageable;

    protected $fillable = ['name', 'vote_count', 'image'];
    protected $appends = ['party_list_name','position_name'];




    
    public function partyList()
    {
        return $this->belongsTo(\App\Models\PartyList::class);
    }

    public function getPartyListNameAttribute(){
        if ($this->partyList) {
            return $this->partyList->name;
        } else {
            return "Independent";
        }
    }



    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
    }

    public function getPositionNameAttribute(){
        if($this->position){
            return $this->position->name;
        }else{
            return 'N/A';
        }
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            //return Vite::asset('images/candidates/' . $value);
            return asset('images/candidates/' . $value);
        } else {
          //  return Vite::asset('images/default/default-user.png');
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
