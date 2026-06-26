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
                    :accepted="$question->best_answer_id === $answer->id"
                />

                <div class="flex-1 min-w-0">
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! $answer->body_html !!}
                    </div>
                    <div class="mt-4 flex items-center justify-end gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Answered {{ $answer->created_date }}</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ $answer->user->url }}">
                                <img src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}" class="h-8 w-8 rounded-full">
                            </a>
                            <a href="{{ $answer->user->url }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ $answer->user->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
