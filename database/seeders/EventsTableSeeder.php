<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('events')->delete();
        
        \DB::table('events')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'EVENT-072025-DOSTIX-0001',
                'name' => 'RSTW & HANDA',
                'year' => '2025',
                'start' => '2025-09-23',
                'end' => '2025-09-25',
                'is_active' => 1,
                'user_id' => 1,
                'created_at' => '2025-07-24 10:23:53',
                'updated_at' => '2025-07-24 10:23:53',
            ),
        ));

        
    }
}