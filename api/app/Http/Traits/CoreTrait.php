<?php

namespace App\Http\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait CoreTrait
{
    /**
     * Build exception response
     * @param int $statusCode
     * @param object $response
     * @param boolean $isError
     * @return array[]|NULL[]
     */
    public function buildJsonResponse($response, $statusCode, $isError = null)
    {
        if (is_null($isError) && $statusCode !== 200) {
            $isError = true;
        }

        return [
            'status_code' => $statusCode,
            'response'   => $this->buildResponse($response, $isError)
        ];
    }

    /**
     * Build response
     * @param string $message
     * @param boolean $isError
     * @return array
     */
    public function buildResponse($message, $isError = false)
    {
        if ($isError) {
            $data = ['error' => $message];
        } else {
            if ($message instanceof LengthAwarePaginator) {
                $data = $message;
            } else {
                if (is_array($message) && array_key_exists('data', $message)) {
                    $data = $message;
                } else {
                    $data = ['data' => $message];
                    if (!empty($message->additional)) {
                        $data = array_merge($message->additional, $data);
                    }
                }
            }
        }

        return $data;
    }
}
