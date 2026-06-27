<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="text-xl font-semibold mb-4">
            {{ $question->answers_count }} {{ Str::plural('answer', $question->answers_count) }}
        </h2>

        @include('layouts._messages')

        @foreach ($question->answers as $answer)
            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <div class="flex gap-6">
                <x-vote-controls
                    :votes="$answer->votes_count"
                    variant="answer"
                    :answer="$answer"
                    :accepted="$question->best_answer_id === $answer->id"
                />

                <div class="flex-1 min-w-0">
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! $answer->body_html !!}
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 shrink-0">
                            @can('update', $answer)
                                <a href="{{ route('questions.answers.edit', [$question, $answer]) }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                    {{ __('Edit') }}
                                </a>
                            @endcan
                            @can('delete', $answer)
                                <form method="post" action="{{ route('questions.answers.destroy', [$question, $answer]) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('{{ __('Are you sure?') }}')">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <x-author-meta :model="$answer" label="Answered" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
