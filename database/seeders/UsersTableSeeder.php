<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'rij-0311',
                'email' => 'kradjumli@gmail.com',
                'password' => '$2y$12$JNbJTB4fe5ry1ASL1FtPOe1Sec8.ITNHQlcNz8/yy7BP5feIxUZjC',
                'role' => 'Administrator',
                'is_active' => 1,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-15 08:46:33',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 10:28:49',
                'updated_at' => '2025-07-24 10:28:49',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'jbt0716',
                'email' => 'dost9jbt@gmail.com',
                'password' => '$2y$12$XP.hmyZX6V9gIV6qH5LPZu3TLc0JwJqgvNl8MJqOxtZs59Ml.rGIu',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 12:48:32',
                'updated_at' => '2025-07-24 12:48:32',
            ),
            2 => 
            array (
                'id' => 3,
                'username' => 'jea1124',
                'email' => 'jealvarez.dost9@gmail.com',
                'password' => '$2y$12$vRjjSb/slSIYogG2HNJCrugUvWWvtJT9/eq1KECnHSBnztLRC7mFa',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 12:49:25',
                'updated_at' => '2025-07-24 12:51:26',
            ),
            3 => 
            array (
                'id' => 4,
                'username' => 'krs0127',
                'email' => 'kristinemaesarita27@gmail.com',
                'password' => '$2y$12$muRxaD3TBvJex3t7E9ScUOzLNzM4z8WfjRjaK2BXCNvLB3KJemoWe',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:03:00',
                'updated_at' => '2025-07-24 13:03:00',
            ),
            4 => 
            array (
                'id' => 5,
                'username' => 'jdc0605',
                'email' => 'jhaykhaycee@gmail.com',
                'password' => '$2y$12$NQZOJKTjseEDy7VBMbiOy..q.8lYPZHBKA42LVGf9rC7Il2rPn0bK',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:03:48',
                'updated_at' => '2025-07-24 13:03:48',
            ),
            5 => 
            array (
                'id' => 6,
                'username' => 'jye0624',
                'email' => 'johnkenesmas@gmail.com',
                'password' => '$2y$12$YpR/PmHZchs50/pOls2WweC.a3sshzYh6MUtXqScAcI1IGSF81fve',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:04:15',
                'updated_at' => '2025-07-24 13:04:15',
            ),
            6 => 
            array (
                'id' => 7,
                'username' => 'jtf0723',
                'email' => 'schezzo_july@yahoo.com',
                'password' => '$2y$12$myXEjZXqY.LOb9pbr/3gBOcU1jRd9lp4RzCZNVbpg1vI.aF0WF9jO',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:05:06',
                'updated_at' => '2025-07-24 13:05:06',
            ),
            7 => 
            array (
                'id' => 8,
                'username' => 'aam0920',
                'email' => 'aigel.martinez1492@gmail.com',
                'password' => '$2y$12$.1XvxjEXxnpONF.DYJhpeO9STurDNtd72dMj7U5ZUCBdhHRA/BQSK',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:05:43',
                'updated_at' => '2025-07-24 13:05:43',
            ),
            8 => 
            array (
                'id' => 9,
                'username' => 'clq1214',
                'email' => 'carlosyl_quinte@yahoo.com',
                'password' => '$2y$12$hsyvLsU1tDB5Gsasibprb.hS5cjr51erOHWhFSWntyeHM2SbjqcNC',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:07:40',
                'updated_at' => '2025-07-24 13:07:40',
            ),
            9 => 
            array (
                'id' => 10,
                'username' => 'mbb0704',
                'email' => 'marvin.basira@gmail.com',
                'password' => '$2y$12$j6EIatDAUmvXsUqQf/gVcu.1CoBErhUkRJSOKO8F8pvb2b0WF2JPq',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:08:20',
                'updated_at' => '2025-07-24 13:08:20',
            ),
            10 => 
            array (
                'id' => 11,
                'username' => 'crr0918',
                'email' => 'cc.rawr.07@gmail.com',
                'password' => '$2y$12$Fq2J/g8Z604B.wsr/tBuYeT9to38TkM/BZhzbU62hiDxO.Jp8D4XS',
                'role' => 'Session Manager',
                'is_active' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => NULL,
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2025-07-24 13:09:04',
                'updated_at' => '2025-07-24 13:09:04',
            ),
        ));

        
    }
}