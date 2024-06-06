<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to like a question', function () {
    //    Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    //    Act :: agir
    $route = route('question.like', $question);

    post($route);

    //    Assert :: verificar
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);
});
