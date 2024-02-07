<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /*
    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Question $question): bool
    {
    }

    public function create(User $user): bool
    {
    }
    */

    public function update(User $user, Question $question): bool
    {
        return $user->can('update', $question->course);
    }

    public function delete(User $user, Question $question): bool
    {
        return $user->can('update', $question->course);
    }

    /*
    public function restore(User $user, Question $question): bool
    {
    }

    public function forceDelete(User $user, Question $question): bool
    {
    }
    */
}
