<?php

/**
 * Response body
 *
 * @param boolean $status Response Status.
 * @param integer $code Response code.
 * @param string $message Response message.
 * @param mixed $data Response data.
 * @param string $details Response data's details.
 * @return array
 */

use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Object_;

if (!function_exists('responseData')) {
    function responseData(bool $status, int $code, string $message, $data = "", $details = null): array
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
    function errorLog(string $method, string $message, array $data): void
    {
        Log::error($method . '-' . $message, $data);
    }
}

/**
 * Return current Unix timestamp with microseconds as integer
 *
 * Note: microtime(true) losses some precision (https://stackoverflow.com/a/25559420)
 *
 * @return int
 */
function microtime_int()
{
    $mt = explode(' ', microtime());
    return ((int) $mt[1]) * 1000 + ((int) round($mt[0] * 1000));
}

/**
 * Return the date with "Y-m-d H:i:s.v" format
 *
 * @param int $timestamp
 */
if (!function_exists('convertToDateTimeString')) {
    function convertToDateTimeString($timestamp)
    {
        if ($timestamp) {
            $float_timestamp = number_format($timestamp / 1000, 3, '.', '');
            return DateTime::createFromFormat('U.v', $float_timestamp)
                ->setTimezone(new DateTimeZone('Asia/Dhaka'))
                ->format('Y-m-d H:i:s.v');
        }
    }
}
