<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Question') }}
            </h2>
            <a href="{{ route('questions.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                {{ __('Back to all questions') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('questions.update', $question) }}" method="post" class="space-y-6" novalidate>
                        @method('PUT')
                        @include('questions._form', ['buttonText' => __('Update Question')])
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
