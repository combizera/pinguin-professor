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

it('should be able to unlike a question', function () {
    //    Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    //    Act :: agir
    $route = route('question.unlike', $question);

    post($route);

    //    Assert :: verificar
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,
    ]);
});

it('should not be able to like more than 1 time', function () {
    //    Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);

    //    Act :: agir
    $route = route('question.like', $question);

    post($route);
    post($route);
    post($route);
    post($route);

    //    Assert :: verificar
    expect(
        $user->votes()->where('question_id', '=', $question->id)->get()
    )
            ->tohaveCount(1);
});
