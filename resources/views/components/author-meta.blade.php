@props([
    'model',
    'label',
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $label }} {{ $model->created_date }}</span>
    <div class="flex items-center gap-2">
        <a href="{{ $model->user->url }}">
            <img src="{{ $model->user->avatar }}" alt="{{ $model->user->name }}" class="h-8 w-8 rounded-full">
        </a>
        <a href="{{ $model->user->url }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            {{ $model->user->name }}
        </a>
    </div>
</div>
