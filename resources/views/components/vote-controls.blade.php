@props([
    'votes' => 0,
    'variant' => 'question',
    'accepted' => false,
    'answer' => null,
    'question' => null,
])

@php
    $voteUrl = match (true) {
        $variant === 'question' && $question && auth()->check() && auth()->user()->can('vote', $question)
            => route('questions.vote', $question),
        $variant === 'answer' && $answer && auth()->check()
            => route('answers.vote', $answer),
        default => null,
    };

    $userVote = match ($variant) {
        'question' => $question?->user_vote,
        'answer' => $answer?->user_vote,
        default => null,
    };

    $usefulLabel = $variant === 'question'
        ? __('This question is useful')
        : __('This answer is useful');

    $notUsefulLabel = $variant === 'question'
        ? __('This question is not useful')
        : __('This answer is not useful');

    $favoritePayload = $variant === 'question' && $question
        ? [
            'id' => $question->id,
            'is_favorited' => $question->is_favorited,
            'favorites_count' => $question->favorites_count,
        ]
        : null;
@endphp

<div
    @if ($voteUrl)
        x-data="{
            votesCount: {{ $votes }},
            userVote: @js($userVote),
            async castVote(vote) {
                const response = await fetch(@js($voteUrl), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ vote }),
                });

                if (! response.ok) {
                    return;
                }

                const data = await response.json();
                this.votesCount = data.votes_count;
                this.userVote = data.user_vote;
            },
        }"
    @endif
    {{ $attributes->merge(['class' => 'flex flex-col items-center shrink-0 min-w-[60px] text-center text-gray-600 dark:text-gray-400']) }}
>
    @if ($voteUrl)
        <button type="button"
            @click="castVote(1)"
            :title="userVote === 1 ? @js(__('Undo your upvote')) : @js($usefulLabel)"
            :class="userVote === 1
                ? 'text-orange-500 hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-300'
                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
            class="block cursor-pointer">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 3.5l7.5 9H4.5L12 3.5z" />
            </svg>
        </button>
    @elseif ($variant === 'answer' && $answer)
        <span title="{{ $usefulLabel }}" class="block text-gray-300 dark:text-gray-600 cursor-default">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 3.5l7.5 9H4.5L12 3.5z" />
            </svg>
        </span>
    @elseif ($variant === 'question' && $question)
        <span title="{{ $usefulLabel }}" class="block text-gray-300 dark:text-gray-600 cursor-default">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 3.5l7.5 9H4.5L12 3.5z" />
            </svg>
        </span>
    @else
        <span class="block text-gray-300 dark:text-gray-600 cursor-default">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 3.5l7.5 9H4.5L12 3.5z" />
            </svg>
        </span>
    @endif

    @if ($voteUrl)
        <span x-text="votesCount" class="block text-2xl font-medium text-gray-700 dark:text-gray-200">{{ $votes }}</span>
    @else
        <span class="block text-2xl font-medium text-gray-700 dark:text-gray-200">{{ $votes }}</span>
    @endif

    @if ($voteUrl)
        <button type="button"
            @click="castVote(-1)"
            :title="userVote === -1 ? @js(__('Undo your downvote')) : @js($notUsefulLabel)"
            :class="userVote === -1
                ? 'text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300'
                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
            class="block cursor-pointer">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 20.5l-7.5-9h15L12 20.5z" />
            </svg>
        </button>
    @elseif ($variant === 'answer' && $answer)
        <span title="{{ $notUsefulLabel }}" class="block text-gray-300 dark:text-gray-600 cursor-default">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 20.5l-7.5-9h15L12 20.5z" />
            </svg>
        </span>
    @elseif ($variant === 'question' && $question)
        <span title="{{ $notUsefulLabel }}" class="block text-gray-300 dark:text-gray-600 cursor-default">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 20.5l-7.5-9h15L12 20.5z" />
            </svg>
        </span>
    @else
        <span class="block text-gray-300 dark:text-gray-600 cursor-default">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 20.5l-7.5-9h15L12 20.5z" />
            </svg>
        </span>
    @endif

    @if ($favoritePayload)
        <div
            data-vue-favorite
            data-question='@json($favoritePayload)'
            data-signed-in="@json(auth()->check())"
        ></div>
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
                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 011.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
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
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 011.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        @endcan
    @endif
</div>
