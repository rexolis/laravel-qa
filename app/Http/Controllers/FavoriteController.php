<?php

namespace App\Http\Controllers;

use App\Models\Question;

class FavoriteController extends Controller
{
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());

        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }

        return back();
    }

    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        if (request()->expectsJson()) {
            return response()->json(null, 204);
        }
        
        return back();
    }
}
