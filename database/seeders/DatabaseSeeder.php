<?php

namespace Database\Seeders;

use App\Models\UserInformation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \DB::table('users')->insert([
        //     'username' => 'rij-0311',
        //     'email' => 'kradjumli@gmail.com',
        //     'password' => bcrypt('Idost9!@#$%'),
        //     'role' => 'Administrator',
        //     'is_active' => 1,
        //     'email_verified_at' => '2024-05-15 08:46:33',
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // \DB::table('user_profiles')->insert([
        //     'firstname' => 'Ra-ouf',
        //     'lastname' => 'Jumli',
        //     'middlename' => 'Indanan',
        //     'avatar' => 'avatar.jpg',
        //     'sex' => 'Male',
        //     'birthdate' => '1994-03-11',
        //     'contact_no' => '09171531652',
        //     'user_id' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        $this->call(LocationRegionsTableSeeder::class);
        $this->call(LocationProvincesTableSeeder::class);
        $this->call(LocationMunicipalitiesTableSeeder::class);
        $this->call(LocationBarangaysTableSeeder::class);
        $this->call(DropdownsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserProfilesTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventDetailsTableSeeder::class);
        $this->call(EventVenuesTableSeeder::class);
        $this->call(HotelsTableSeeder::class);
        $this->call(HotelLocationsTableSeeder::class);
        $this->call(HotelRatesTableSeeder::class);
    }
}
