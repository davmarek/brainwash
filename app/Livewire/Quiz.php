<?php

namespace App\Livewire;

use App\Enums\QuizState;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Question;
use App\Models\UserResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.quiz')]
class Quiz extends Component
{

    #[Locked]
    public Course $course;

    #[Locked]
    public Collection $questions;

    public int|null $selectedAnswerId = null;

    public string $openAnswer = '';

    #[Locked]
    public QuizState $state = QuizState::Answering;

    #[Computed]
    public function currentQuestion(): Question|null
    {
        return Question::with('answers')->find($this->questions->first());
    }

    public function mount(Course $course): void
    {
        $this->course = $course;

        // get all the question ids, that the current user didn't answer yet
        $this->questions = $course
            ->questions()
            ->whereDoesntHave('results', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->select('id')
            ->get()
            ->map(fn($item) => $item['id'])
            ->collect();
    }


    public function selectAnswer(int|null $answerId): void
    {
        // don't allow changing selected answer after submitting
        if ($this->state == QuizState::ShowingResults) {
            return;
        }

        // only set the selected_answer if the answer is in the current question
        if ($this->currentQuestion->answers()->whereId($answerId)->exists()) {
            $this->selectedAnswerId = $answerId;
        }
    }

    public function submit(): void
    {
        if ($this->currentQuestion->is_open_question) {
            // open (text) question
            $this->validateOnly('openAnswer',
                ['openAnswer' => 'required'],
                ['openAnswer.required' => "Yo, fill the answer, you cunt"]
            );
            $this->state = QuizState::SelfReview;
        } else {
            // closed options question
            $this->validateOnly( 'selectedAnswerId',
                ['selectedAnswerId' => 'required'],
                ['selectedAnswerId.required' => "Yo, select an answer, you cunt"]
            );

            /** @var Answer $answer */
            $answer = $this->currentQuestion->answers()->find($this->selectedAnswerId);
            if ($answer->is_correct) {
                session()->flash('result', "Correct");
            } else {
                session()->flash('result', "Wrong");
            }

            UserResult::updateOrCreate(
                [
                    'course_id' => $this->course->id,
                    'user_id' => auth()->user()->id,
                    'question_id' => $this->currentQuestion->id,
                ],
                [
                    'selected_answer_id' => $answer->id,
                    'is_correct' => $answer->is_correct,
                ]
            );

            $this->state = QuizState::ShowingResults;
        }
    }

    public function selfReview(bool $correct): void
    {
        UserResult::updateOrCreate(
            [
                'course_id' => $this->course->id,
                'user_id' => auth()->user()->id,
                'question_id' => $this->currentQuestion->id,
            ],
            [
                'is_correct' => $correct,
            ]
        );

        $this->next();
    }

    public function next(): void
    {
        $this->questions->shift();
        $this->reset('selectedAnswerId', 'openAnswer', 'state');
        unset($this->currentQuestion);
    }

    public function skip(): void
    {
        $first = $this->questions->shift();
        $this->questions->push($first);
        $this->reset('selectedAnswerId', 'openAnswer', 'state');
    }


    public function render()
    {
        return view('livewire.quiz');
    }
}
