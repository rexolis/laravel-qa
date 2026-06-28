@csrf

<div>
    <x-input-label for="question-title" :value="__('Question Title')" />
    <x-text-input
        id="question-title"
        name="title"
        type="text"
        class="mt-1 block w-full {{ $errors->has('title') ? 'border-red-500 focus:border-red-500 focus:ring-red-500 dark:border-red-500' : '' }}"
        :value="old('title', $question->title)"
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

<div class="flex items-center gap-4 pt-4">
    <x-primary-button>{{ $buttonText }}</x-primary-button>
</div>
