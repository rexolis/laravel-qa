<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="text-xl font-semibold mb-4">
            {{ $question->answers_count }} {{ Str::plural('answer', $question->answers_count) }}
        </h2>

        @include('layouts._messages')

        @foreach ($question->answers as $answer)
            @include('answers._answer')
        @endforeach
    </div>
</div>
