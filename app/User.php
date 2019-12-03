<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Answer;
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

    protected $appends = ['url', 'avatar'];         // bind to getAvatarAttribute for UserInfo.vue

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

        return $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();

        return $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote($relationship, $model, $vote)
    {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        }
        else {
            $relationship->attach($model, ['vote' => $vote]);
        }
        $model->load('votes');
        $downVotes = (int) $model->downVotes()->sum('vote');
        $upVotes = (int) $model->upVotes()->sum('vote');

        $model->votes_count = $upVotes + $downVotes;
        $model->save();

        return $model->votes_count;
    }

}
