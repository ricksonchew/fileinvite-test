<?php

namespace App\Http\Services\Bookings\Resources;

use \App\Http\Services\Bookings\Resources\UsersResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingsResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $this->whenLoaded('user');
        $meetingRoom = $this->whenLoaded('meetingRoom');

        return [
            'booking_id' => $this->booking_id,
            'booked_by' => $user->first_name . ' ' . $user->last_name,
            'meeting_room' => $meetingRoom->meeting_room_desc,
            'booking_date_from' => $this->booking_date_from,
            'booking_date_to' => $this->booking_date_to,
        ];
    }
}
