<?php

namespace App\Models;

use App\Models\Concerns\Votable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

#[Fillable(['title', 'body', 'user_id', 'views', 'answers_count', 'votes_count'])]
class Question extends Model
{
    use HasFactory, Votable;

    protected $appends = ['created_date'];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'views' => 'integer',
            'answers_count' => 'integer',
            'votes_count' => 'integer',
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt(int $length): string
    {
        return Str::limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml(): string
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //, 'question_id', 'user_id');
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
