<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question)
    {
        $this->authorize('vote', $question);

        $vote = (int) request()->vote;
        auth()->user()->voteQuestion($question, $vote);

        return back();
    }
}
