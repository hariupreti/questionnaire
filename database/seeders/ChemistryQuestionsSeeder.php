<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\answer;
use App\Models\question;
use App\Models\section;

class ChemistryQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionId = section::where("name", "Chemistry")->first("id");
        $questions = [
            [
                'text' => 'What is the chemical symbol for water?',
                'answers' => [
                    'H2O',
                    'CO2',
                    'O2',
                    'H2SO4',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'Which element has the chemical symbol "O"?',
                'answers' => [
                    'Oxygen',
                    'Hydrogen',
                    'Nitrogen',
                    'Carbon',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'What is the chemical formula for table salt?',
                'answers' => [
                    'NaCl',
                    'H2SO4',
                    'CO2',
                    'H2O',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'Which of the following is a noble gas?',
                'answers' => [
                    'Helium',
                    'Nitrogen',
                    'Oxygen',
                    'Carbon',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'What is the chemical symbol for gold?',
                'answers' => [
                    'Au',
                    'Ag',
                    'Fe',
                    'Pb',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => "Which gas is most abundant in the Earth's atmosphere?",
                'answers' => [
                    'Oxygen', 
                    'Carbon dioxide',
                    'Nitrogen',
                    'Argon',
                ],
                'correct_answer_index' => 2,
            ],
            [
                'text' => 'What is the atomic number of carbon?',
                'answers' => [
                    '6',
                    '8',
                    '12',
                    '14',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'What is the chemical formula for sulfuric acid?',
                'answers' => [
                    'NaOH',
                    'HCl',
                    'CH4',
                    'H2SO4', 
                ],
                'correct_answer_index' => 3,
            ],
            [
                'text' => 'What is the chemical formula for methane?',
                'answers' => [
                    'H2O',
                    'CO2',
                    'CH4',
                    'NH3',
                ],
                'correct_answer_index' => 2,
            ],
            [
                'text' => 'Which gas is responsible for the greenhouse effect?',
                'answers' => [
                    'Carbon dioxide',
                    'Oxygen',
                    'Nitrogen',
                    'Argon',
                ],
                'correct_answer_index' => 0,
            ],
            [
                'text' => 'What is the chemical symbol for iron?',
                'answers' => [
                    'Ag', 
                    'Fe',
                    'Pb',
                    'Cu',
                ],
                'correct_answer_index' => 1,
            ],
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
