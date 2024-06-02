<?php

namespace App\Http\Controllers;

use App\Models\Question;
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
                    function (string $attribute, mixed $value, \Closure $fail) {
                        //                        dd($value);
                        if($value[strlen($value) - 1] != '?') {
                            $fail("Are you sure that is a question? It is missing the question mark in the end.");
                        }
                    },
                ],
            ])
        );

        return to_route('dashboard');
    }
}
