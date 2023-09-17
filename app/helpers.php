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

if (!function_exists('responseData')) {
    function responseData($status, $code, $message, $data = "", $details = null)
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
