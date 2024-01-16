<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\User;
use App\Models\UserResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Course::factory()->count(20)->create();

        $course = Course::factory()
            ->for(User::factory(), 'creator')
            ->has(
                Question::factory()
                    ->count(5)
                    ->has(Answer::factory()->is_correct())
                    ->has(Answer::factory()->count(2)),
            )
            ->has(
                Question::factory()
                    ->is_open_question()
                    ->count(20)
            )
            ->create([
                'name' => 'AP5PW',
                'description' => 'Pokročilé webové stránky - more like .NET hell',
            ]);

        $user_david = User::factory()
            ->hasAttached($course, relationship: 'subscribedCourses')
            ->hasAttached($course, relationship: 'editableCourses')
            ->create([
                'name' => 'David Marek',
                'email' => 'davidmarek14@gmail.com',
                'password' => Hash::make('ahoj1234'),
            ]);

        User::factory()
            ->create([
                'name' => 'Petr Nosek',
                'email' => 'petrkes@gmail.com',
                'password' => Hash::make('ahoj1234'),
            ]);

        User::factory()->count(20)->create();

        UserResult::factory()->create([
            'user_id' => $user_david->id,
            'course_id' => $course->id,
            'question_id' => $course->questions()->find(1)->id,
            'selected_answer_id' => $course->questions()->find(1)->answers()->first()->id,
            'is_correct' => $course->questions()->find(1)->answers()->first()->is_correct,
        ]);
        UserResult::factory()->create([
            'user_id' => $user_david->id,
            'course_id' => $course->id,
            'question_id' => $course->questions()->find(2)->id,
            'selected_answer_id' => $course->questions()->find(2)->answers()->first()->id,
            'is_correct' => $course->questions()->find(2)->answers()->first()->is_correct,
        ]);

    }
}
