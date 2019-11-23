<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions() {
        // a question only can have many users
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route("users.show", $this->id);
        return '#';
    }

    public function answers_count()
    {
        return $this->hasMany(Answer::class);
    }

    /* Generate PHP Image (個人頭像) from the hash of email by Gravatar
     * http://en.gravatar.com/site/implement/images/php/
    */

    public function getAvatarAttribute() {
        $email = $this->email;
        $hash = md5( strtolower( trim( $email ) ) );
        $size = 32;
        $url = "https://www.gravatar.com/avatar/" . $hash . "&s=" . $size;
        return $url;

    }
}
