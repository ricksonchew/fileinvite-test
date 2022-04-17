<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'meeting_room_code',
        'booking_date_from',
        'booking_date_to',
    ];

    public function meetingRoom()
    {
        return $this->belongsTo(MeetingRooms::class, 'meeting_room_code', 'meeting_room_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
