<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Answer') }}
            </h2>
            <a href="{{ route('questions.show', $question) }}" class="shrink-0 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                {{ __('Back to question') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('Editing answer for question:') }}
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $question->title }}</span>
                    </p>

                    <hr class="my-4 border-gray-200 dark:border-gray-700">

                    <form action="{{ route('questions.answers.update', [$question, $answer]) }}" method="post" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="answer-body" :value="__('Your answer')" />
                            <textarea
                                id="answer-body"
                                name="body"
                                rows="7"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm {{ $errors->has('body') ? 'border-red-500 focus:border-red-500 focus:ring-red-500 dark:border-red-500' : '' }}"
                            >{{ old('body', $answer->body) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('body')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
