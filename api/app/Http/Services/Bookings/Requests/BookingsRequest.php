<?php

namespace App\Http\Services\Bookings\Requests;

class BookingsRequest
{
    public function ruleCreate()
    {
        return [
            'user_id' => 'required',
            'meeting_room_code' => 'required|string',
            'booking_date_from' => 'required',
            'booking_date_to' => 'required',
        ];
    }
}
