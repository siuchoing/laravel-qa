<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user()
    {
        // $this (module) belong to User
        return $this->belongsTo(User::class);
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        // -> {{ $question->user->url }}
        //return route("questions.show", $this->id);          // where $this reference to $questions in QuestionsController
        return route("questions.show", $this->slug);    // where pass data by boot() from RouteServiceProvider.php
    }

    public function getCreatedDateAttribute()
    {
        // -> {{ $question->created_date }}
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        //dd(\Parsedown::instance()->text($this->body));
        return \Parsedown::instance()->text($this->body);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
        // $question->answer->count();
        //
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        //return $this->belongsToMany(User::class, 'favorites'); //, 'user_id', 'question_id');
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        //return $q1->favorites->where('user_id', $u1->id)->count() > 0
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited;
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

}
