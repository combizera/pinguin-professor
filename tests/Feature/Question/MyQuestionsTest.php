<?php

use App\Models\Question;
use App\Models\User;

it('should be able to list all questions created by me', function () {
    //    Arrange :: preparar
    $wrongUser      = User::factory()->create();
    $wrongQuestions = Question::factory()
        ->for($wrongUser, 'createdBy')
        ->count(10)
        ->create();

    $user      = User::factory()->create();
    $questions = Question::factory()
        ->for($user, 'createdBy')
        ->count(10)
        ->create();

    \Pest\Laravel\actingAs($user);

    //    Act :: agir
    $response = \Pest\Laravel\get(route('question.index'));

    //    Assert :: verificar
    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

    /** @var Question $q */
    foreach ($wrongQuestions as $q) {
        $response->assertDontSee($q->question);
    }
});
