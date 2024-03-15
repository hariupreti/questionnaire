<?php

namespace Database\Seeders;

use App\Models\question;
use App\Models\section;
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

        //Default Section Seeder
        section::create(["name" => "Physics"]);
        section::create(["name" => "Chemistry"]);

        //Default Questions Seeder  
    }
}
