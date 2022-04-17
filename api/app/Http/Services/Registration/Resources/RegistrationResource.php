<?php

namespace App\Http\Services\Registration\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'access_token' => $this->resource['access_token'],
        ];
    }
}
