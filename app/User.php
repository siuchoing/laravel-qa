<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use App\Answer;
use App\Question;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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

    public function answers()
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

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }

    public function favorites()
    {
        //return $this->belongsToMany(Question::class, 'favorites'); //, 'user_id', 'question_id');
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //, 'author_id', 'question_id');
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

    public function posts()
    {
        $type = request()->get('type');

        if ($type === 'questions') {
            $posts = $this->questions()->get();
        } else {
            $posts = $this->answers()->with('question')->get();
            if ($type !== 'answers') {
                $posts2 = $this->questions()->get();
                $posts = $posts->merge($posts2);
            }
        }

        // `collect` helper function can short this structure before I actually return them
        $data = collect();

        foreach ($posts as $post)
        {
            $item = [
                'votes_count' => $post->votes_count,
                'created_at' => $post->created_at->format('M d Y')
            ];

            if ($post instanceof Answer)
            {
                $item['type'] = 'A';
                $item['title'] = $post->question->title;
                $item['accepted'] = $post->question->best_answer_id === $post->id ? true : false;
            }
            elseif ($post instanceof Question)
            {
                $item['type'] = 'Q';
                $item['title'] = $post->title;
                $item['accepted'] = (bool) $post->best_answer_id;
            }

            $data->push($item);
        }
        // sort method will keep the original array keys, so we need to chain in with `values` by values() method
        return $data->sortByDesc('votes_count')->values()->all();
    }

}
