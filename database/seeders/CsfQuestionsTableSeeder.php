<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CsfQuestionsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('csf_questions')->delete();
        
        \DB::table('csf_questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'CC1. Which of the following best describes your awareness of a CC?',
                'sequence' => 1,
                'is_overall' => 0,
                'is_rating' => 0,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            1 => 
            array (
                'id' => 2,
            'name' => 'CC2. If aware of CC (answered 1-3 in CC1), would say that the CC of this was?',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 0,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            2 => 
            array (
                'id' => 3,
            'name' => 'CC3. If aware of CC (answered 1-3 in CC1), how much did the CC help you in your transaction?',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 0,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Responsiveness',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Reliability',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Access & Facilities',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Communication',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Integrity',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Assurance',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Outcome',
                'sequence' => 2,
                'is_overall' => 0,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Considering your complete experience with our agency, how likely would you recommend our services to others?',
                'sequence' => 2,
                'is_overall' => 1,
                'is_rating' => 1,
                'is_active' => 1,
                'created_at' => '2024-04-29 10:17:48',
                'updated_at' => '2024-04-29 10:17:48',
            ),
        ));

        
    }
}