<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $vote = (int) request()->vote;

        auth()->user()->voteAnswer($answer, $vote);

        $answer->refresh();
        $answer->unsetRelation('votes');

        return response()->json([
            'votes_count' => $answer->votes_count,
            'user_vote' => $answer->user_vote,
        ]);
    }
}
