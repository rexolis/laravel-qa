<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ask Question') }}
            </h2>
            <a href="{{ route('questions.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                {{ __('Back to all questions') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('questions.store') }}" method="post" class="space-y-6" novalidate>
                        @csrf

                        <div>
                            <x-input-label for="question-title" :value="__('Question Title')" />
                            <x-text-input
                                id="question-title"
                                name="title"
                                type="text"
                                class="mt-1 block w-full {{ $errors->has('title') ? 'border-red-500 focus:border-red-500 focus:ring-red-500 dark:border-red-500' : '' }}"
                                :value="old('title', $question->title)"
                                autofocus
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="question-body" :value="__('Explain your question')" />
                            <textarea
                                id="question-body"
                                name="body"
                                rows="10"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm {{ $errors->has('body') ? 'border-red-500 focus:border-red-500 focus:ring-red-500 dark:border-red-500' : '' }}"
                            >{{ old('body', $question->body) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Ask this question') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
