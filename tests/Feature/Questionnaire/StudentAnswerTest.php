<?php

use App\Jobs\SendQuestionnaireAnnouncementEmailJob;
use App\Models\questionnaire;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('questionnaire test is accessible for students, once questionnaire created', function () {
    $user = User::factory()->create();
    $response = $this
        ->actingAs($user)
        ->post('/questionnaire',[
            'title' => "Test Questionnaire",
            'selectedExpiryDate' => date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day'))
        ]);

    $uniqueURLHanlder = [
        "valid_till" => date('Y-m-d', strtotime(date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day')))),
        "email" => $user->email,
        "quessionnaire_id" => 1
    ];
    $encryptedURL = encrypt($uniqueURLHanlder, true);

    SendQuestionnaireAnnouncementEmailJob::dispatch($user->email, "Testing the case", $encryptedURL);

    $response = $this->get(route('access.questionnaire',$encryptedURL));

    $response->assertOk();
});

test('test can be submitted by students', function () {
    $user = User::factory()->create();

    $uniqueURLHanlder = [
        "valid_till" => date('Y-m-d', strtotime(date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day')))),
        "email" => $user->email,
        "quessionnaire_id" => 1
    ];
    $encryptedURL = encrypt($uniqueURLHanlder, true);

    SendQuestionnaireAnnouncementEmailJob::dispatch($user->email, "Testing the case", $encryptedURL);

    $saveAnswer = $this->post(route('save.answers'),[
        'questionnaireId' =>  1,
        'studentId' => 1,
        'answerData' => [
            ['que' => 1, 'ans' => 2]
        ]
    ]);

    $saveAnswer->assertRedirect();
});