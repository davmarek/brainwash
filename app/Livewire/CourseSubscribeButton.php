<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CourseSubscribeButton extends Component
{
    public Course $course;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    #[Computed(persist: true)]
    public function isSubscribed(): bool
    {
        return $this->course->subscribedUsers()->where('user_id', Auth::user()->id)->exists();
    }


    public function submit(): void
    {
        $user = Auth::user();
        if ($this->isSubscribed) {
            $user->subscribedCourses()->detach($this->course->id);
        } else {
            $user->subscribedCourses()->attach($this->course->id);
        }
        $user->save();
        unset($this->isSubscribed);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.course-subscribe-button');
    }
}
