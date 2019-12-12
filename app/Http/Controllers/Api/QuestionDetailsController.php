<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Question;

class QuestionDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Question $question)
    {
        // consider App/QuestionsController@show
        $question->increment('views');

        return new QuestionResource($question);
    }
}
