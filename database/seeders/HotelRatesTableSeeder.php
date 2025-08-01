<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HotelRatesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hotel_rates')->delete();
        
        \DB::table('hotel_rates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Superior Twin',
                'detail' => '2 Single Beds',
                'rate' => '3920.00',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Superior Matrimonal',
                'detail' => '1 Queen Size Bed',
                'rate' => '3920.00',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Deluxe Twin',
                'detail' => '2 Double Beds',
                'rate' => '4256.00',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Junior Suite',
                'detail' => '1 King Size Bed',
                'rate' => '5376.00',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Executive Suite',
                'detail' => '1 King Size Bed',
                'rate' => '7280.00',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Extra Person',
                'detail' => 'With Breakfast',
                'rate' => '1000.00',
                'hotel_id' => 3,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Superior Room',
                'detail' => '-',
                'rate' => '5500.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Deluxe Double Room',
                'detail' => '-',
                'rate' => '6500.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Delux King',
                'detail' => '-',
                'rate' => '6500.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Premier Room',
                'detail' => '-',
                'rate' => '6000.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Deluxe Handicap',
                'detail' => '-',
                'rate' => '6500.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Junior Suite',
                'detail' => '-',
                'rate' => '12000.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Bridal Suite',
                'detail' => '-',
                'rate' => '12000.00',
                'hotel_id' => 4,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Standard Room',
                'detail' => '1 Single Bed - ₱1,300.00',
                'rate' => '2330.00',
                'hotel_id' => 6,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Twin Bedroom',
                'detail' => '2 Single Beds - ₱1,800.00',
                'rate' => '2710.00',
                'hotel_id' => 6,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Matrimonial Bed',
                'detail' => '1 Queen Bed - ₱1,700.00',
                'rate' => '2610.00',
                'hotel_id' => 6,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Family Room',
                'detail' => '1 Queen Bed - ₱2,100.00',
                'rate' => '3450.00',
                'hotel_id' => 6,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Additional Bed',
                'detail' => '-',
                'rate' => '500.00',
                'hotel_id' => 6,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Superior Room',
                'detail' => '1 Pax',
                'rate' => '2114.56',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Superior Room',
                'detail' => '2 Pax',
                'rate' => '2338.56',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Deluxe Room',
                'detail' => '1 Pax',
                'rate' => '2562.56',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Deluxe Room',
                'detail' => '2 Pax',
                'rate' => '2786.56',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Junior Suite Room',
                'detail' => '-',
                'rate' => '3122.56',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Suite Room',
                'detail' => '-',
                'rate' => '3682.56',
                'hotel_id' => 7,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
        ));

        
    }
}