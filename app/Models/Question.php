<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

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
