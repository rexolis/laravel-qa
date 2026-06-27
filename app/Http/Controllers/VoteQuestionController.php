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

        $question->refresh();
        $question->unsetRelation('votes');

        return response()->json([
            'votes_count' => $question->votes_count,
            'user_vote' => $question->user_vote,
        ]);
    }
}
