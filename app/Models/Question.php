<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Question extends Model
{
    use HasFactory;

    public function openAnswer(): Attribute
    {
        return Attribute::make(
            get: fn(string $value, array $attributes) => $attributes['is_open_question'] ? $value : '',
        );
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(UserResult::class);
    }
}
