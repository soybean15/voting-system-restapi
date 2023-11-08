<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomVerifyEmailNotification;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sendEmailVerificationNotification()
    {
    $this->notify(new CustomVerifyEmailNotification);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin(){
        // foreach($this->roles as $role){
        //     if($role->role == 'Admin'){
        //         return true;
        //     }

        // }
        // return false;
       

        if ($this->roles->contains('role', 'Admin')) {
            return true;
        }
    
        return false;
    }

    public function voteLog(){
        return $this->hasOne(VoteLog::class);
    }

    public function hasVoted(){
        if($this->voteLog){
            return true;
        }
        return false;
    }
}
