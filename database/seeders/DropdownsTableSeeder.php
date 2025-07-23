<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DropdownsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dropdowns')->delete();
        
        \DB::table('dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'n/a',
                'classification' => 'n/a',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Male',
                'classification' => 'Sex',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Female',
                'classification' => 'Sex',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'QR Code',
                'classification' => 'Method',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Scanner',
                'classification' => 'Method',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Onsite',
                'classification' => 'Method',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Pending',
                'classification' => 'Attendance Status',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Present',
                'classification' => 'Attendance Status',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Absent',
                'classification' => 'Attendance Status',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Excused',
                'classification' => 'Attendance Status',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Remote',
                'classification' => 'Attendance Status',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Speaker',
                'classification' => 'Participant Type',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
        ));

        
    }
}