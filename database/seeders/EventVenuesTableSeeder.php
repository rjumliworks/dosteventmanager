<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventVenuesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('event_venues')->delete();
        
        \DB::table('event_venues')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'VN-072025-DOSTIX-0001',
                'name' => 'Madrid Hall',
                'establishment' => 'Palacio del Sur',
                'address' => 'Governor Camins Avenue, Zamboanga City',
                'event_id' => 1,
                'created_at' => '2025-07-24 11:33:34',
                'updated_at' => '2025-07-24 11:33:34',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'VN-072025-DOSTIX-0002',
                'name' => 'Valencia Hall',
                'establishment' => 'Palacio del Sur',
                'address' => 'Governor Camins Avenue, Zamboanga City',
                'event_id' => 1,
                'created_at' => '2025-07-24 11:34:21',
                'updated_at' => '2025-07-24 11:34:21',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'VN-072025-DOSTIX-0003',
                'name' => 'Cordova Hall',
                'establishment' => 'Palacio del Sur',
                'address' => 'Governor Camins Avenue, Zamboanga City',
                'event_id' => 1,
                'created_at' => '2025-07-24 11:34:27',
                'updated_at' => '2025-07-24 11:43:36',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'VN-072025-DOSTIX-0004',
                'name' => 'Ibiza Hall',
                'establishment' => 'Palacio del Sur',
                'address' => 'Governor Camins Avenue, Zamboanga City',
                'event_id' => 1,
                'created_at' => '2025-07-24 11:34:36',
                'updated_at' => '2025-07-24 11:34:36',
            ),
        ));

        
    }
}