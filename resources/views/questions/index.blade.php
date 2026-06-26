<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('All Questions') }}
            </h2>
            <a href="{{ route('questions.create') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                {{ __('Ask Question') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @include('layouts._messages')

                    @foreach ($questions as $question)
                        <div class="flex gap-6">
                            <div class="flex flex-col items-center gap-2 min-w-20 text-sm text-gray-600 dark:text-gray-400">
                                <div class="text-center">
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $question->votes }}</span>
                                    {{ Str::plural('vote', $question->votes) }}
                                </div>
                                <div @class([
                                    'text-center px-2 py-1 rounded border text-xs font-medium',
                                    'border-green-500 bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300 dark:border-green-600' => $question->status === 'answered-accepted',
                                    'border-blue-500 bg-blue-50 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-600' => $question->status === 'answered',
                                    'border-gray-300 bg-gray-50 text-gray-600 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300' => $question->status === 'unanswered',
                                ])>
                                    <span class="font-semibold">{{ $question->answers_count }}</span>
                                    {{ Str::plural('answer', $question->answers_count) }}
                                </div>
                                <div class="text-center">
                                    {{ $question->views }} {{ Str::plural('view', $question->views) }}
                                </div>
                            </div>
                            <div class="flex-1 mb-6">
                                <div class="flex items-center justify-between gap-4">
                                    <h3 class="text-lg font-semibold">
                                        <a href="{{ $question->url }}" class="text-gray-900 hover:text-gray-700 dark:text-gray-100 dark:hover:text-gray-300">
                                            {{ $question->title }}
                                        </a>
                                    </h3>
                                    @if (auth()->id() === $question->user_id)
                                        <div class="flex items-center gap-4 shrink-0">
                                            <a href="{{ route('questions.edit', $question) }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                                {{ __('Edit') }}
                                            </a>
                                            <form method="post" action="{{ route('questions.destroy', $question) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-lg font-light text-gray-600 dark:text-gray-400">
                                    Asked by
                                    <a href="{{ $question->user->url }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ $question->user->name }}
                                    </a>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $question->created_date }}</span>
                                </p>
                                <p class="mt-2 text-gray-600 dark:text-gray-300">
                                    {{ Str::limit($question->body, 250) }}
                                </p>
                            </div>
                        </div>
                        @unless ($loop->last)
                            <hr class="my-4 border-gray-200 dark:border-gray-700">
                        @endunless
                    @endforeach

                    <div class="mt-6">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
