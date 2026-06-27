<?php

namespace App\Models;

use App\Models\Concerns\Votable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['body', 'user_id'])]
class Answer extends Model
{
    use HasFactory, Votable;

    protected $appends = ['created_date', 'body_html'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }

    protected static function booted(): void
    {
        static::created(function (Answer $answer) {
            $answer->question?->increment('answers_count');
        });

        static::deleted(function (Answer $answer) {
            $answer->question?->decrement('answers_count');
        });
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
    }
}
