<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('should be able to create a new question bigger than 255 characters', function () {
    //    Antes de criar qualquer teste precisamos levar em conta esses 3 A's
    //    Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
    //    Act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 256) . '?',
    ]);
    //    Assert :: verificar
    $request->assertRedirect(route('dashboard'));
    \Pest\Laravel\assertDatabaseCount('questions', 1);
    \Pest\Laravel\assertDatabaseHas('questions', [
        'question' => str_repeat('*', 256) . '?',
    ]);
});

it('should check if ends with question mark ?', function () {
    //    Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
    //    Act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);
    //    Assert :: verificar
    $request->assertSessionHasErrors([
        'question' => "Are you sure that is a question? It is missing the question mark in the end.",
    ]);
    \Pest\Laravel\assertDatabaseCount('questions', 0);
});

it('should have at least 10 characters', function () {
    //    Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
    //    Act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);
    //    Assert :: verificar
    $request->assertSessionHasErrors(
        ['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]
    );
    \Pest\Laravel\assertDatabaseCount('questions', 0);
});
