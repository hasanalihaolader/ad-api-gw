<?php

/**
 * Response body
 *
 * @param boolean $status Response Status.
 * @param integer $code Response code.
 * @param string $message Response message.
 * @param array $data Response data.
 * @param string $details Response data's details.
 * @return array
 */

use Illuminate\Support\Facades\Log;

if (!function_exists('responseData')) {
    function responseData(bool $status, int $code, string $message, array $data = [], $details = null): array
    {
        $response = [
            'status'  => $status,
            'code'    => $code,
            'message' => $message
        ];

        if ($details) {
            $response['data'] = [
                'details' => $details
            ];
        } else {
            $response['data'] = $data;
        }

        return $response;
    }
}

if (!function_exists('infoLog')) {
    function infoLog(string $method, string $message, array $data): void
    {
        Log::info($method . '-' . $message, $data);
    }
}

if (!function_exists('errorLog')) {
    function infoLog(string $method, string $message, array $data): void
    {
        Log::error($method . '-' . $message, $data);
    }
}
