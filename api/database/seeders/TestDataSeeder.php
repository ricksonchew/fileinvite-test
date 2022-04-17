<?php

namespace Database\Seeders;

use App\Http\Services\Bookings\Services\BookingsServiceInterface;
use App\Http\Services\Registration\Services\RegistrationServiceInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    const ITERATION = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_registerUser();
        $this->_createBooking();
    }

    private function _createBooking()
    {
        for ($ctr = 0; $ctr < self::ITERATION; $ctr++) {
            $now = Carbon::now();
            $iteration = $ctr + 1;
            request()->merge([
                'user_id' => $iteration,
                'meeting_room_code' => 'room_' . $iteration,
                'booking_date_from' => $now->hours($iteration)->toDateTimeString(),
                'booking_date_to' => $now->hours($iteration + 1)->toDateTimeString(),
            ],);
            $service = app()->make(BookingsServiceInterface::class);
            $service->create();
        }
    }

    private function _registerUser()
    {
        for ($ctr = 0; $ctr < self::ITERATION; $ctr++) {
            $password = 'qwerty';
            request()->merge([
                'email' => Str::lower(Str::random(10)) . '@test.com',
                'password' => $password,
                'password_confirmation' => $password,
                'first_name' => Str::random(10),
                'last_name' => Str::random(10)
            ]);
            $service = app()->make(RegistrationServiceInterface::class);
            $service->registration();
        }
    }
}
