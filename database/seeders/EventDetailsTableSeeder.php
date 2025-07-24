<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventDetailsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('event_details')->delete();
        
        \DB::table('event_details')->insert(array (
            0 => 
            array (
                'id' => 1,
            'description' => 'Innovations in Climate and Disaster Resilience Nationwide Exposition 2025 (Mindanao Leg)',
                'venue' => 'Palacio del Sur',
                'address' => 'Governor Camins Avenue',
                'longitude' => '122.065746',
                'latitude' => '6.918712',
                'barangay_code' => '097332021',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'event_id' => 1,
                'created_at' => '2025-07-24 10:23:53',
                'updated_at' => '2025-07-24 10:23:53',
            ),
        ));

        
    }
}