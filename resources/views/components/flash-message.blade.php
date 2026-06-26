@props(['type' => 'success'])

@php
$styles = match ($type) {
    'error' => [
        'container' => 'border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-900/20',
        'icon' => 'text-red-400',
        'text' => 'text-red-800 dark:text-red-300',
    ],
    default => [
        'container' => 'border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-900/20',
        'icon' => 'text-green-400',
        'text' => 'text-green-800 dark:text-green-300',
    ],
};
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    {{ $attributes->merge(['class' => "mb-4 rounded-lg border p-4 {$styles['container']}"]) }}
    role="alert"
>
    <div class="flex items-start gap-3">
        @if ($type === 'error')
            <svg class="h-5 w-5 shrink-0 {{ $styles['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>
        @else
            <svg class="h-5 w-5 shrink-0 {{ $styles['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
        @endif

        <p class="flex-1 text-sm font-medium {{ $styles['text'] }}">
            {{ $slot }}
        </p>

        <button type="button" @click="show = false" class="shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" aria-label="{{ __('Dismiss') }}">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
        </button>
    </div>
</div>
