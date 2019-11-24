<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    /*
     * Eloquent Event:
     *  - retrieved
     *  - created, creating
     *  - updated, updating
     *  - saved, saving
     *  - deleted, deleting
     *  - restored, restoring
    */
    public static function boot() {
        parent::boot();

        # echo a message when create a answer each time, and save new value
        static::created(function($answer) {
            $answer->question->increment('answers_count');          // to count answer
            // $answer->question->save();                           // laravel will save automatically
            // echo "Answer created.\n";
        });

        # update the answer_count while deleted an answer
        static::deleted(function($answer) {
            $question = $answer->question;
            $question->decrement('answers_count');                  // to count answer
            if($question->best_answer_id === $answer->id) {
                $question->best_answer_id === NULL;
                $question->save();
            }
        });

        // static::saved(function($answer) {
        //     echo "Answer saved.\n";
        // });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }
}
