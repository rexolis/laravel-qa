<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $question->title }}
            </h2>
            <a href="{{ route('questions.index') }}" class="shrink-0 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                {{ __('Back to all questions') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! $question->body_html !!}
                    </div>
                    <div class="mt-4 flex items-center justify-end gap-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Asked {{ $question->created_date }}</span>
                        <div class="flex items-center gap-2">
                            <a href="{{ $question->user->url }}">
                                <img src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}" class="h-8 w-8 rounded-full">
                            </a>
                            <a href="{{ $question->user->url }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                {{ $question->user->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-semibold">
                        {{ $question->answers_count }} {{ Str::plural('answer', $question->answers_count) }}
                    </h2>

                    @foreach ($question->answers as $answer)
                        <hr class="my-4 border-gray-200 dark:border-gray-700">

                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! $answer->body_html !!}
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
