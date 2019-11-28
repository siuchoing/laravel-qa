<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Question;

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

    public function favorites()
    {
        //return $this->belongsToMany(Question::class, 'favorites'); //, 'user_id', 'question_id');
        return $this->belongsToMany(Question::class, 'favorites'); //, 'user_id', 'question_id')->withTimestamps()
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote)
    {
        // $u1->voteQuestions()->where('votable_id', $q1->id)->exists()     => true
        $voteQuestions = $this->voteQuestions();
        if ($voteQuestions->where('votable_id', $question->id)->exists()) {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        }
        else {
            $voteQuestions->attach($question, ['vote' => $vote]);
        }
        $question->load('votes');
        $downVotes = (int) $question->downVotes()->sum('vote');
        $upVotes = (int) $question->upVotes()->sum('vote');

        $question->votes_count = $upVotes + $downVotes;
        $question->save();
    }

}
