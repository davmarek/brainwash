<?php

namespace App\Enums;

enum QuizState: string
{
    case Answering = 'answering';
    case ShowingResults = 'results';
    case SelfReview = 'review';
}
