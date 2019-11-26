<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    // __invoke($_obj)
    public function __invoke(Answer $answer)
    {
        //dd("Accept the answer");
        $answer->question->acceptBestAnswer($answer);
        return back();
    }
}
