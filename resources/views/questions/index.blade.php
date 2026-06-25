<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($questions as $question)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold">{{ $question->title }}</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ Str::limit($question->body, 250) }}
                            </p>
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
