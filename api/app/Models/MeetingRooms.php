<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_room_code',
        'meeting_room_desc',
    ];
}
