<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to publish a question', function () {
    //    Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);
    actingAs($user);

    //    Act :: agir
    put(route('question.publish', $question))
        ->assertRedirect();
    $question->refresh();

    //    Assert :: verificar
    expect($question)
        ->draft->toBeFalse();
});

it('should make sure that only the person who has create the question can publish the question', function () {
    //    Arrange :: preparar
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    //    Act :: agir
    actingAs($wrongUser);
    //    Assert :: verificar
    put(route('question.publish', $question))
        ->assertForbidden();

    //    Act :: agir
    actingAs($rightUser);
    //    Assert :: verificar
    put(route('question.publish', $question))
        ->assertRedirect();
});
