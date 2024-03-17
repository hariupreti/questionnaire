tests/Feature/ProfileTest.php<?php

use App\Models\questionnaire;
use App\Models\User;

test('questionnaire create functionality work', function () {
    $user = User::factory()->create();
    $qustionaire = questionnaire::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post(route('questionnaire.save'),$qustionaire);

    $response->assertOk();
});