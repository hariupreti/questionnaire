<?php

use App\Models\questionnaire;
use App\Models\User;

test('questionnaire can be created', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/questionnaire',[
            'title' => "Test Questionnaire",
            'selectedExpiryDate' => date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day'))
        ]);

    $response->assertRedirect("/");
});

test('questionnaire can be updated', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/questionnaire',[
            'id' => 1,
            'title' => "Test Questionnaire",
            'selectedExpiryDate' => date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day'))
        ]);

    $response->assertRedirect("/");
});

test('questionnaire can be deleted', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/questionnaire',["id"=>1]);

    $response->assertRedirect("/");
});