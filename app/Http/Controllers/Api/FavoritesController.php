<?php

namespace App\Http\Controllers\Api;

use App\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());

        return response()->json(null, 204); // 204 status for successfully fulfilled the request
    }

    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        return response()->json(null, 204); // 204 status for successfully fulfilled the request
    }
}
