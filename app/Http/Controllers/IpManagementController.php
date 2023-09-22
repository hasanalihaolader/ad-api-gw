<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\HttpClient;
use Illuminate\Http\Client\RequestException;

class IpManagementController extends Controller
{
    use HttpClient;

    /**
     * Get a request to Create IP through call IP MANAGEMENT MS .
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $ip_management_base_url = env('IP_MANAGEMENT_APPLICATION_BASE_URL');
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
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_response->getStatusCode() : 500;
        } catch (RequestException $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_response->getStatusCode() : 500;
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
            $ip_management_base_url = env('IP_MANAGEMENT_APPLICATION_BASE_URL');
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
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_response->getStatusCode() : 500;
        } catch (RequestException $e) {
            $exception_response = $e->getResponse();
            $response_body =  $exception_response->getBody()->getContents();
            $response = json_decode($response_body, true);
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [$e->getMessage()]
            );
            $response_code = method_exists($exception_response, 'getStatusCode') ? $exception_response->getStatusCode() : 500;
        }
        return response()->json($response, $response_code);
    }
}
