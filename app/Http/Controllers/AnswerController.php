<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Question $question, Request $request)
    {
        $question->answers()->create($request->validate([
            'body' => 'required'
        ]) + ['user_id' => \Auth::id()]);

        return back()->with('success', "Your answer has been submitted successfully");
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->body_html
            ]);
        }

        return redirect()->route('questions.show', $question->slug)->with('success', "Your answer has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been removed',
            ]);
        }

        return back()->with('success', "Your answer has been deleted successfully");
    }
}
