<?php

namespace App\Models\Concerns;

use App\Models\User;

trait Votable
{
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable')->withPivot('vote');
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

    public function getUserVoteAttribute(): ?int
    {
        if (! auth()->check()) {
            return null;
        }

        if ($this->relationLoaded('votes')) {
            $vote = $this->votes->firstWhere('id', auth()->id());

            return $vote ? (int) $vote->pivot->vote : null;
        }

        $vote = $this->votes()
            ->where('users.id', auth()->id())
            ->value('vote');

        return $vote !== null ? (int) $vote : null;
    }
}
