<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hotels')->delete();
        
        \DB::table('hotels')->insert(array (
            0 => 
            array (
                'id' => 3,
                'code' => 'HOT-072025-0001',
                'name' => 'Marcian Garden Hotel',
                'link' => 'https://www.facebook.com/marciangardenhotel',
                'email' => 'reservations@marciangardenhotel.com',
                'contact_no' => '0936 151 7008',
                'avatar' => 'marcian.png',
                'is_active' => 1,
                'created_at' => '2025-07-31 09:01:22',
                'updated_at' => '2025-07-31 09:01:22',
            ),
            1 => 
            array (
                'id' => 4,
                'code' => 'HOT-072025-0002',
                'name' => 'Garden Orchid Hotel & Resort Corporation',
                'link' => 'https://www.facebook.com/gardenorchidhotels',
                'email' => 'gardenorchidhotel@gmail.com',
                'contact_no' => '0962 991 0032',
                'avatar' => 'garden.png',
                'is_active' => 1,
                'created_at' => '2025-07-31 09:05:40',
                'updated_at' => '2025-07-31 09:05:40',
            ),
            2 => 
            array (
                'id' => 6,
                'code' => 'HOT-072025-0003',
                'name' => 'Azenith Royale Hotel',
                'link' => 'https://www.facebook.com/pages/Azenith%20Royale%20Hotel',
                'email' => 'azenithrh.zam@gmail.com',
                'contact_no' => '0905 765 3148',
                'avatar' => 'azenith.jpg',
                'is_active' => 1,
                'created_at' => '2025-07-31 09:12:18',
                'updated_at' => '2025-07-31 09:12:18',
            ),
            3 => 
            array (
                'id' => 7,
                'code' => 'HOT-072025-0004',
                'name' => 'L’ Meridian Suites',
                'link' => 'https://www.facebook.com/lmeridiansuites/',
                'email' => 'lmeridiansuites@gmail.com',
                'contact_no' => '0917 310 9348',
                'avatar' => 'meridian.png',
                'is_active' => 1,
                'created_at' => '2025-07-31 09:16:12',
                'updated_at' => '2025-07-31 09:16:12',
            ),
        ));

        
    }
}