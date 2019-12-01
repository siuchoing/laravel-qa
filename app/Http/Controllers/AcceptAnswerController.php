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
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => "You have accepted this answer as best answer"
            ]);
        }

        return back();
    }
}
