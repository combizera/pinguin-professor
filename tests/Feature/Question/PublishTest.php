<?php

use App\Models\Question;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to publish a question', function () {
    //    Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => true]);
    actingAs($user);

    //    Act :: agir
    put(route('question.publish', $question))
        ->assertRedirect();
    $question->refresh();

    //    Assert :: verificar
    expect($question)
        ->draft->toBeFalse();
});
