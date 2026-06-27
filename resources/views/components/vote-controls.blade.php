@props([
    'votes' => 0,
    'variant' => 'question',
    'accepted' => false,
    'answer' => null,
    'question' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center shrink-0 min-w-[60px] mr-8 text-center text-gray-600 dark:text-gray-400']) }}>
    <a href="#" title="{{ $variant === 'question' ? __('This question is useful') : __('This answer is useful') }}"
        class="block text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 3.5l7.5 9H4.5L12 3.5z" />
        </svg>
    </a>

    <span class="block text-2xl font-medium text-gray-700 dark:text-gray-200">{{ $votes }}</span>

    <a href="#" title="{{ $variant === 'question' ? __('This question is not useful') : __('This answer is not useful') }}"
        class="block text-gray-300 dark:text-gray-600 cursor-default">
        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 20.5l-7.5-9h15L12 20.5z" />
        </svg>
    </a>

    @if ($variant === 'question' && $question)
        @auth
            <a href="#"
                title="{{ __('Click to mark as favorite question (Click again to undo)') }}"
                @class([
                    'block mt-2 cursor-pointer',
                    'text-amber-400 hover:text-amber-500' => $question->is_favorited,
                    'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' => ! $question->is_favorited,
                ])
                onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit();">
                <svg class="w-6 h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005z" clip-rule="evenodd" />
                </svg>
                <span class="block text-xs mt-0.5">{{ $question->favorites_count }}</span>
            </a>
            <form id="favorite-question-{{ $question->id }}"
                action="{{ $question->is_favorited ? route('questions.unfavorite', $question) : route('questions.favorite', $question) }}"
                method="POST"
                class="hidden">
                @csrf
                @if ($question->is_favorited)
                    @method('DELETE')
                @endif
            </form>
        @else
            <span title="{{ __('Click to mark as favorite question (Click again to undo)') }}"
                class="block mt-2 text-gray-300 dark:text-gray-600 cursor-default">
                <svg class="w-6 h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005z" clip-rule="evenodd" />
                </svg>
                <span class="block text-xs mt-0.5">{{ $question->favorites_count }}</span>
            </span>
        @endauth
    @elseif ($answer)
        @can('accept', $answer)
            <a href="#"
                title="{{ __('Mark this answer as best answer') }}"
                @class([
                    'block mt-2 cursor-pointer',
                    'text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300' => $accepted,
                    'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' => ! $accepted,
                ])
                onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();">
                <svg class="w-6 h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                </svg>
            </a>
            <form id="accept-answer-{{ $answer->id }}" action="{{ route('answers.accept', $answer) }}" method="POST" class="hidden">
                @csrf
            </form>
        @else
            @if ($accepted)
                <span title="{{ __('The question owner accepted this answer as best answer') }}"
                    class="block mt-2 text-green-600 dark:text-green-400">
                    <svg class="w-6 h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        @endcan
    @endif
</div>
