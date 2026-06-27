@php
    $answerPayload = [
        'id' => $answer->id,
        'question_id' => $answer->question_id,
        'body' => $answer->body,
        'body_html' => $answer->body_html,
        'created_date' => $answer->created_date,
        'user' => $answer->user,
    ];
@endphp

<div class="post-item flex gap-6 min-w-0">
    <x-vote-controls
        :votes="$answer->votes_count"
        variant="answer"
        :answer="$answer"
        :accepted="$question->best_answer_id === $answer->id"
    />

    <div class="flex-1 min-w-0 w-full">
        <div
            data-vue-answer
            class="w-full min-w-0"
            data-answer='@json($answerPayload)'
            data-can-update="@json(auth()->user()?->can('update', $answer) ?? false)"
            data-can-delete="@json(auth()->user()?->can('delete', $answer) ?? false)"
            data-delete-url="{{ route('questions.answers.destroy', [$question, $answer]) }}"
        ></div>
    </div>
</div>
