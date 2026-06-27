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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex gap-6">
                        <x-vote-controls :votes="$question->votes_count" variant="question" :question="$question" />

                        <div class="flex-1 min-w-0">
                            <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {!! $question->body_html !!}
                            </div>
                            <div class="mt-4 flex items-center justify-end">
                                <x-author-meta :model="$question" label="Asked" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('answers._index')
            @auth
                @include('answers._create')
            @endauth
        </div>
    </div>
</x-app-layout>
