<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HotelLocationsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hotel_locations')->delete();
        
        \DB::table('hotel_locations')->insert(array (
            0 => 
            array (
                'id' => 3,
                'address' => 'Gov Camins Avenue',
                'longitude' => '122.065917',
                'latitude' => '6.919048',
                'barangay_code' => '097332062',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            1 => 
            array (
                'id' => 4,
                'address' => 'Gov Camins Avenue',
                'longitude' => '122.06406',
                'latitude' => '6.918428',
                'barangay_code' => '097332062',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            2 => 
            array (
                'id' => 5,
                'address' => 'Gov Camins Avenue',
                'longitude' => '122.06626',
                'latitude' => '6.919474',
                'barangay_code' => '097332062',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'hotel_id' => 6,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            3 => 
            array (
                'id' => 6,
                'address' => 'Gov Camins Avenue',
                'longitude' => '122.067301',
                'latitude' => '6.919489',
                'barangay_code' => '097332062',
                'municipality_code' => '097332000',
                'province_code' => '097300000',
                'region_code' => '090000000',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
        ));

        
    }
}