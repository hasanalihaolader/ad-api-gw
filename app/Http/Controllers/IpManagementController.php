<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HttpClient;
use Illuminate\Http\Client\RequestException;

class IpManagementController extends Controller
{
    use HttpClient;

    private $ip_management_application_base_url = '';

    public function __construct()
    {
        $this->ip_management_application_base_url = env('IP_MANAGEMENT_APPLICATION_BASE_URL');
    }


    /**
     * Request to Get Ip List .
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        try {
            $ip_management_base_url = $this->ip_management_application_base_url;
            $endpoint = 'ip';
            $ip_list = $this->httpRequest(
                $ip_management_base_url,
                [],
                $endpoint,
                'GET',
                [
                    'Accept' => 'application/json'
                ]
            );
            $response = json_decode($ip_list->getBody()->getContents(), true);
            $response_code = Response::HTTP_OK;
        } catch (\Exception $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            $exception_code =  $exception_response->getStatusCode();
            errorLog(
                __METHOD__,
                Response::$statusTexts[$exception_code],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_code : 500;
        }
        return response()->json($response, $response_code);
    }


    /**
     * Get a request to Create IP through call IP MANAGEMENT MS .
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $ip_management_base_url = $this->ip_management_application_base_url;
            $endpoint = 'ip/store';
            $create_new_ip_api_response = $this->httpRequest(
                $ip_management_base_url,
                $request->all(),
                $endpoint,
                'POST',
                [
                    'Accept' => 'application/json'
                ]
            );
            $response = json_decode($create_new_ip_api_response->getBody()->getContents(), true);
            $response_code = Response::HTTP_OK;
        } catch (\Exception $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            $exception_code =  $exception_response->getStatusCode();
            errorLog(
                __METHOD__,
                Response::$statusTexts[$exception_code],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_code : 500;
        }
        return response()->json($response, $response_code);
    }

    /**
     * Get a request to Update IP through call IP MANAGEMENT MS .
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $ip_management_base_url = $this->ip_management_application_base_url;
            $endpoint = 'ip/update/' . $id;
            $update_new_ip_api_response = $this->httpRequest(
                $ip_management_base_url,
                $request->all(),
                $endpoint,
                'PATCH',
                [
                    'Accept' => 'application/json'
                ]
            );
            $response = json_decode($update_new_ip_api_response->getBody()->getContents(), true);
            $response_code = Response::HTTP_OK;
        } catch (\Exception $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            $exception_code =  $exception_response->getStatusCode();
            errorLog(
                __METHOD__,
                Response::$statusTexts[$exception_code],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_code : 500;
        }
        return response()->json($response, $response_code);
    }

    /**
     * Get a request to Update IP through call IP MANAGEMENT MS .
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getById(Request $request, int $id): JsonResponse
    {
        try {
            $ip_management_base_url = $this->ip_management_application_base_url;
            $endpoint = 'ip/' . $id;
            $update_new_ip_api_response = $this->httpRequest(
                $ip_management_base_url,
                $request->all(),
                $endpoint,
                'GET',
                [
                    'Accept' => 'application/json'
                ]
            );
            $response = json_decode($update_new_ip_api_response->getBody()->getContents(), true);
            $response_code = Response::HTTP_OK;
        } catch (\Exception $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            $exception_code =  $exception_response->getStatusCode();
            errorLog(
                __METHOD__,
                Response::$statusTexts[$exception_code],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_code : 500;
        }
        return response()->json($response, $response_code);
    }



}
