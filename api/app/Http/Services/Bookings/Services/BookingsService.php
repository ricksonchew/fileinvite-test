<?php

namespace App\Http\Services\Bookings\Services;

use App\Http\Services\Bookings\Resources\BookingsResource;
use App\Http\Services\Bookings\Requests\BookingsRequest;
use App\Models\Bookings;
use Illuminate\Support\Facades\DB;

class BookingsService implements BookingsServiceInterface
{
    private $_request;

    public function __construct()
    {
        $this->_request = request();
    }

    public function list()
    {
        return BookingsResource::collection(Bookings::with(['meetingRoom', 'user'])->get());
    }

    public function create()
    {
        validator()->make(request()->all(), app(BookingsRequest::class)->ruleCreate())->validate();

        try {
            DB::beginTransaction();
            Bookings::create([
                'user_id' => $this->_request->user_id,
                'meeting_room_code' => $this->_request->meeting_room_code,
                'booking_date_from' => $this->_request->booking_date_from,
                'booking_date_to' => $this->_request->booking_date_to,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new DatabaseException($e->getMessage());
        }
    }
}

