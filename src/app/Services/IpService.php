<?php

namespace App\Services;

use App\Enums\Ip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HttpClient;
use Exception;

class IpService
{
    use HttpClient;

    private static $ip_management_application_base_url = '';

    public static function handle(Request $request, string $api_version): array
    {
        // throw new Exception('ss');
        self::$ip_management_application_base_url = env(
            strtoupper('IP_MANAGEMENT_APPLICATION_BASE_URL_' . $api_version)
        );
        if (empty(self::$ip_management_application_base_url)) {
            $response_code = Response::HTTP_NOT_ACCEPTABLE;
            return [
                responseData(false, $response_code, 'This api version is not implement at this time'),
                $response_code
            ];
        }
        $consumer_endpoint  = config('endpoint_mapping_ip_ms.' . $request->path());
        if (empty($consumer_endpoint)) {
            $response_code = Response::HTTP_NOT_FOUND;
            return [
                responseData(false, $response_code, Response::$statusTexts[$response_code]),
                $response_code
            ];
        }
        return self::apiRequestAndResponseHandle($request, $consumer_endpoint);
    }

    /**
     * Handle request and response Ip management MS api
     *
     * @param  Request  $request
     * @return array
     */
    public static function apiRequestAndResponseHandle(Request $request, string $end_point): array
    {
        try {
            $end_point = $end_point . '/' . $request->input('id');
            $ip_management_base_url = self::$ip_management_application_base_url;
            $ip_list = self::httpRequest(
                $ip_management_base_url,
                $request->all(),
                $end_point,
                $request->getMethod(),
                [
                    'Accept' => 'application/json'
                ]
            );
            $response = json_decode($ip_list->getBody()->getContents(), true);
            $response_code = Response::HTTP_OK;
        } catch (\GuzzleHttp\Exception\ServerException | \GuzzleHttp\Exception\RequestException $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            $exception_code =  $exception_response->getStatusCode();
            errorLog(
                __METHOD__,
                Response::$statusTexts[$exception_code],
                [$e->getMessage()]
            );
            $response_code = (method_exists($exception_response, 'getStatusCode') ?
                $exception_code :
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (\Exception $e) {
            dd($e->getMessage());
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = responseData(
                false,
                $response_code,
                Response::$statusTexts[$response_code],
                []
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[$response_code],
                [$e->getMessage()]
            );
        }
        return [$response, $response_code];
    }
}
