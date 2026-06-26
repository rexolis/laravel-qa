<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-lg font-semibold">{{ __('Your Answer') }}</h3>

        <hr class="my-4 border-gray-200 dark:border-gray-700">

        <form action="{{ route('questions.answers.store', $question) }}" method="post">
            @csrf

            <div>
                <x-input-label for="answer-body" :value="__('Your answer')" class="sr-only" />
                <textarea
                    id="answer-body"
                    name="body"
                    rows="7"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm {{ $errors->has('body') ? 'border-red-500 focus:border-red-500 focus:ring-red-500 dark:border-red-500' : '' }}"
                >{{ old('body') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('body')" />
            </div>

            <div class="mt-4">
                <x-primary-button>{{ __('Submit') }}</x-primary-button>
            </div>
        </form>
    </div>
</div>
