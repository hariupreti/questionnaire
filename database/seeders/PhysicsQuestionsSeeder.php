<?php

namespace Database\Seeders;

use App\Models\answer;
use App\Models\question;
use App\Models\section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhysicsQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionId = section::where("name", "physics")->first("id");
        $questions = [
            [
                'text' => 'What is the formula for force?',
                'answers' => [
                    'F = ma',
                    'F = mv',
                    'F = m',
                    'F = v',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'A vehicle moving on a circular path experiences ________?',
                'answers' => [
                    'centripetal force',
                    'centrifugal force',
                    'gravitational force',
                    'None of the above',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'What is the force of attraction between any two bodies by virtue of their masses is called?',
                'answers' => [
                    'Electromagnetic Force',
                    'Gravitational Force',
                    'Centripetal Force',
                    'Nuclear Force',
                ],
                'correct_answer_index' => 1,
            ],
            [
                'text' => 'Which of the following is the unit of Solid Angle?',
                'answers' => [
                    'radian',
                    'steradian',
                    'm2',
                    'π',
                ],
                'correct_answer_index' => 1,
            ],
            [
                'text' => 'Angle of friction is _______:',
                'answers' => [
                    'equal to angle of repose',
                    'equal to twice the angle of repose',
                    'is greater than the angle of repose',
                    'is less than the angle of repose',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'Work done will NOT be zero in which of the following case/cases?',
                'answers' => [
                    'When displacement is zero',
                    'When angle between force and displacement vector is zero',
                    'When angle between force and displacement vector is 90°',
                    'When force is zero',
                ],
                'correct_answer_index' => 1,
            ],
            [
                'text' => 'Which of the following is incorrect:',
                'answers' => [
                    'Gravitational force of attraction is independent of nature of intervening medium',
                    'Gravitational forces are central forces',
                    'Gravitational forces are non-conservative forces',
                    'All of the above',
                ],
                'correct_answer_index' => 2,
            ],
            [
                'text' => 'What is the value of acceleration due to gravity at the centre of the earth?',
                'answers' => [
                    '1 N/kg',
                    '0',
                    '-9.8 N/kg',
                    '9.8 N/kg',
                ],
                'correct_answer_index' => 1,
            ],
            [
                'text' => 'In which of the following situations, the state of weightlessness can be observed?',
                'answers' => [
                    'When objects fall freely under gravity',
                    'When a satellite revolves in its orbit around the earth',
                    'When bodies are at null points in outer space',
                    'All of the above',
                ],
                'correct_answer_index' => 3,
            ],
            [
                'text' => 'What is the value of Universal Gravitational Constant?',
                'answers' => [
                    "6.67×10-9 N–m2 kg–2",
                    "6.67×10-10 N–m2 kg–2",
                    '6.67×1011 N–m2 kg–2',
                    '6.67×10-11 N–m2 kg–2',
                ],
                'correct_answer_index' => 3,
            ],
            [
                'text' => 'What is the body called which does not have any tendency to recover its original configuration, on the removal of deforming force?',
                'answers' => [
                    'Perfectly plastic',
                    'Perfectly elastic',
                    'Perfectly ductile',
                    'None of the above',
                ],
                'correct_answer_index' => 0,
            ]
        ];

        foreach ($questions as $questionData) {
            $question = question::create(['question_text' => $questionData['text'], 'section_id' => $sectionId->id]);
            foreach ($questionData['answers'] as $index => $answerText) {
                $isCorrect = $index === $questionData['correct_answer_index'];
                $recordAnswer = answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $answerText,
                ]);
                if ($isCorrect) {
                    question::where('id', $question->id)->update(['correct_answer_id' => $recordAnswer->id]);
                }
            }
        }
    }
}
