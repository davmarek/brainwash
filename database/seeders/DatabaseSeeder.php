<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
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
                ['title' => 'Elektro'],
                ['title' => 'Webovky'],
            )
            ->create();


        $user_david = \App\Models\User::factory()
            ->hasAttached($courses, relationship: 'subscribedCourses')
            ->create([
                'name' => 'David Marek',
                'email' => 'davidmarek14@gmail.com',
                'password' => Hash::make('ahoj1234'),
            ]);

        $user_petr = \App\Models\User::factory()
            ->hasAttached($courses, relationship: 'subscribedCourses')
            ->create([
                'name' => 'Petr Nosek',
                'email' => 'petrkes@gmail.com',
                'password' => Hash::make('ahoj1234'),
            ]);

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
