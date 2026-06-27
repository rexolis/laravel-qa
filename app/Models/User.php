<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function getUrlAttribute()
    {
        // return route("questions.show", $this->id);
        return '#';
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getAvatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/{$hash}?s=32";
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //, 'author_id', 'question_id');
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable')->withPivot('vote');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable')->withPivot('vote');
    }

    public function voteQuestion(Question $question, int $vote): void
    {
        $this->recordVote($this->voteQuestions(), $question, $vote);
    }

    public function voteAnswer(Answer $answer, int $vote): void
    {
        $this->recordVote($this->voteAnswers(), $answer, $vote);
    }

    private function recordVote($relationship, Question|Answer $model, int $vote): void
    {
        $existing = $relationship->where($model->getKeyName(), $model->id)->first();

        if ($existing && (int) $existing->pivot->vote === $vote) {
            $relationship->detach($model->id);
        } else {
            $relationship->syncWithoutDetaching([
                $model->id => ['vote' => $vote],
            ]);
        }

        $model->votes_count = (int) $model->upVotes()->sum('vote')
            + (int) $model->downVotes()->sum('vote');

        $model->save();
    }
}
