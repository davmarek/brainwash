<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\User;
use App\Models\UserResult;
use Database\Factories\AnswerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $courses = Course::factory()
            ->count(2)
            ->for(User::factory(), 'creator')
            ->has(
                Question::factory()
                    ->count(3)
                    ->has(Answer::factory()->is_correct())
                    ->has(Answer::factory()->count(2)),
            )
            ->has(
                Question::factory()
                    ->is_open_question()
                    ->count(2)
            )
            ->sequence(
                [
                    'name' => 'Analogová a číslicová technika',
                    'description' => 'AP5AL Elektro',

                ],
                [
                    'name' => 'Pokročilé webové stránky',
                    'description' => 'AP5PW',
                ],
            )
            ->create();

        Course::factory()->count(20)->create();


        $user_david = User::factory()
            ->hasAttached($courses, relationship: 'subscribedCourses')
            ->hasAttached($courses, relationship: 'editableCourses')
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
            'course_id' => $courses[0]->id,
            'question_id' => $courses[0]->questions()->find(1)->id,
            'selected_answer_id' => $courses[0]->questions()->find(1)->answers()->first()->id,
            'is_correct' => $courses[0]->questions()->find(1)->answers()->first()->is_correct,
        ]);
        UserResult::factory()->create([
            'user_id' => $user_david->id,
            'course_id' => $courses[0]->id,
            'question_id' => $courses[0]->questions()->find(2)->id,
            'selected_answer_id' => $courses[0]->questions()->find(2)->answers()->first()->id,
            'is_correct' => $courses[0]->questions()->find(2)->answers()->first()->is_correct,
        ]);


    }
}
