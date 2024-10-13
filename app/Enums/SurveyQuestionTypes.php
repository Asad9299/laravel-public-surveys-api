<?php

namespace App\Enums;

enum SurveyQuestionTypes: string
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Select = 'select';
    case Radio = 'radio';
    case Checkbox = 'checkbox';
}
