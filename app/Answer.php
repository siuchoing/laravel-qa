<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
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

        # echo a message when create a answer each time
        static::created(function($answer) {
            $answer->question->increment('answers_count');          // to count answer
            //$answer->question->save();
            // echo "Answer created.\n";
        });
        static::saved(function($answer) {
            // echo "Answer saved.\n";
        });
    }
}
