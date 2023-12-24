<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editors(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class,'editors')
            ->withPivot('can_add_editors')
            ->withTimestamps();
    }

    public function subscribedUsers(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'subscriptions')
            ->withTimestamps();
    }

    public function results(): HasMany
    {
        return $this->hasMany(UserResult::class);
    }
}
