<?php

namespace App\Http\Services\Login\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'access_token' => $this->resource['access_token'],
        ];
    }
}
