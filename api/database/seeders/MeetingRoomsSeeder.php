<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingRoomsSeeder extends Seeder
{
    const ITERATION = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($ctr = 0; $ctr < self::ITERATION; $ctr++) {
            DB::table('meeting_rooms')->insert([
                'meeting_room_code' => 'room_' . $ctr + 1,
                'meeting_room_desc' => 'Room ' . $ctr + 1,
            ]);
        }
    }
}
