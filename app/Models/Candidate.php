<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];
    public function position(){
        return $this.belongsTo(Position::class);
    }

    public function getImageAttribute($value)
{
    if ($value) {
        return asset('images/candidates/' . $value);
    } else {
        return asset('images/default/default-user.png');
    }
}
}
