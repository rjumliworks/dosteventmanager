<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profiles')->delete();
        
        \DB::table('user_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Ra-ouf',
                'lastname' => 'Jumli',
                'middlename' => 'Indanan',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => '1994-03-11',
                'contact_no' => '09171531652',
                'avatar' => 'avatar.jpg',
                'user_id' => 1,
                'created_at' => '2025-07-24 10:28:49',
                'updated_at' => '2025-07-24 10:28:49',
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'Jun Carlo',
                'lastname' => 'Tangon',
                'middlename' => 'B',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09279347641',
                'avatar' => 'avatar.jpg',
                'user_id' => 2,
                'created_at' => '2025-07-24 12:48:32',
                'updated_at' => '2025-07-24 12:48:32',
            ),
            2 => 
            array (
                'id' => 3,
                'firstname' => 'Judilyn',
                'lastname' => 'Alvarez',
                'middlename' => 'Enoferio',
                'suffix' => NULL,
                'sex' => 'Female',
                'birthdate' => NULL,
                'contact_no' => '09953275424',
                'avatar' => 'avatar.jpg',
                'user_id' => 3,
                'created_at' => '2025-07-24 12:49:25',
                'updated_at' => '2025-07-24 12:49:25',
            ),
            3 => 
            array (
                'id' => 4,
                'firstname' => 'Kristine Mae',
                'lastname' => 'Sarita',
                'middlename' => 'Rodriguez',
                'suffix' => NULL,
                'sex' => 'Female',
                'birthdate' => NULL,
                'contact_no' => '09454681800',
                'avatar' => 'avatar.jpg',
                'user_id' => 4,
                'created_at' => '2025-07-24 13:03:00',
                'updated_at' => '2025-07-24 13:03:00',
            ),
            4 => 
            array (
                'id' => 5,
                'firstname' => 'John Kenneth',
                'lastname' => 'Cabral',
                'middlename' => 'De Asis',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09177160242',
                'avatar' => 'avatar.jpg',
                'user_id' => 5,
                'created_at' => '2025-07-24 13:03:48',
                'updated_at' => '2025-07-24 13:03:48',
            ),
            5 => 
            array (
                'id' => 6,
                'firstname' => 'John Ken',
                'lastname' => 'Esmas',
                'middlename' => 'Yamuta',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09171171407',
                'avatar' => 'avatar.jpg',
                'user_id' => 6,
                'created_at' => '2025-07-24 13:04:15',
                'updated_at' => '2025-07-24 13:04:15',
            ),
            6 => 
            array (
                'id' => 7,
                'firstname' => 'Julius',
                'lastname' => 'Fojas',
                'middlename' => 'Taghap',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09668152170',
                'avatar' => 'avatar.jpg',
                'user_id' => 7,
                'created_at' => '2025-07-24 13:05:06',
                'updated_at' => '2025-07-24 13:05:06',
            ),
            7 => 
            array (
                'id' => 8,
                'firstname' => 'Aigel',
                'lastname' => 'Martinez',
                'middlename' => 'Anastacio',
                'suffix' => NULL,
                'sex' => 'Female',
                'birthdate' => NULL,
                'contact_no' => '09772093653',
                'avatar' => 'avatar.jpg',
                'user_id' => 8,
                'created_at' => '2025-07-24 13:05:43',
                'updated_at' => '2025-07-24 13:05:43',
            ),
            8 => 
            array (
                'id' => 9,
                'firstname' => 'Carlo Syl',
                'lastname' => 'Quinte',
                'middlename' => 'Labuca',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09154834386',
                'avatar' => 'avatar.jpg',
                'user_id' => 9,
                'created_at' => '2025-07-24 13:07:40',
                'updated_at' => '2025-07-24 13:07:40',
            ),
            9 => 
            array (
                'id' => 10,
                'firstname' => 'Marvin',
                'lastname' => 'Basira',
                'middlename' => 'Bacus',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09365879496',
                'avatar' => 'avatar.jpg',
                'user_id' => 10,
                'created_at' => '2025-07-24 13:08:20',
                'updated_at' => '2025-07-24 13:08:20',
            ),
            10 => 
            array (
                'id' => 11,
                'firstname' => 'Christian Carl',
                'lastname' => 'Resente',
                'middlename' => 'Rivera',
                'suffix' => NULL,
                'sex' => 'Male',
                'birthdate' => NULL,
                'contact_no' => '09472864179',
                'avatar' => 'avatar.jpg',
                'user_id' => 11,
                'created_at' => '2025-07-24 13:09:04',
                'updated_at' => '2025-07-24 13:09:04',
            ),
        ));

        
    }
}