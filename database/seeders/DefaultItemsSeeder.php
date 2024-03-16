<?php

namespace Database\Seeders;

use App\Models\question;
use App\Models\section;
use App\Models\student;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Default User Seeder
        User::factory()->count(1)->create(); //Admin User

        //Default Student Seeder
        $students = [
            ['name' => 'John Adam', 'email' => "johnadam@questionnaire.test"],
            ['name' => 'Hari Upreti', 'email' => "hariupreti@questionnaire.test"],
            ['name' => 'Bren Lsow', 'email' => "bren@questionnaire.test"],
            ['name' => 'Lorem Ipsum', 'email' => "loremipsum@questionnaire.test"],
            ['name' => 'Kishor Shrestha', 'email' => "kishorshrestha@questionnaire.test"],
        ];

        student::insert($students);

        //Default Section Seeder
        section::create(["name" => "Physics"]);
        section::create(["name" => "Chemistry"]);

        //Default Questions Seeder  
    }
}
