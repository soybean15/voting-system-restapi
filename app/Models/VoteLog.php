<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteLog extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-m-d H:i:s';

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
