<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    // make sure user has sign-in
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());

        if(request()->expectsJson())
        {
            return response()->json(null, 204); // 204 status for successfully fulfilled the request
        }
        return back();
    }

    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        if(request()->expectsJson())
        {
            return response()->json(null, 204); // 204 status for successfully fulfilled the request
        }
        return back();
    }
}
