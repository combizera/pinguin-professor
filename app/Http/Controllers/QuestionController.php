<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        // outro modo
        //        $question = new Question();
        //        $question->question = request()->question;
        //        $question->save();

        Question::query()->create(
            request()->validate([
                'question' => [
                    'required',
                    'min:10',
                    new EndWithQuestionMarkRule(),
                ],
            ])
        );

        return to_route('dashboard');
    }
}
