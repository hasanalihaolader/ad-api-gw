<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpClient;

class IpManagementController extends Controller
{
    use HttpClient;

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $ip_management_base_url = env('IP_MANAGEMENT_APPLICATION_BASE_URL');
            $endpoint = 'ip/store';
            $create_new_ip_api_response = $this->httpRequest(
                $ip_management_base_url,
                $request->all(),
                $endpoint,
                'POST',
            );
            $response = json_decode($create_new_ip_api_response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $response_body =  $e->getResponse()->getBody()->getContents();
            $response = json_decode($response_body, true);
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [$e->getMessage()]
            );
        }
        return response()->json($response);
    }
}
