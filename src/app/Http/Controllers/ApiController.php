<?php

namespace App\Http\Controllers;

use App\Enums\MicroService;
use App\Services\IpService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class ApiController extends BaseController
{
    private static function getMsBindingService(string $ms): ?string
    {
        $binding_services = [
            strtoupper(MicroService::IP) => IpService::class
        ];
        return $binding_services[strtoupper($ms)] ?? null;
    }

    public static function handle(Request $request): JsonResponse
    {
        try {
            $path_segments = explode('/', $request->path());
            $ms = $path_segments[2] ?? null;
            $api_version = $path_segments[1];

            $binding_service = self::getMsBindingService($ms);
            if (empty($binding_service)) {
                $response_code = Response::HTTP_NOT_ACCEPTABLE;
                list($response, $response_code) =
                    [
                        responseData(false, $response_code, 'This service is not implement at this time'),
                        $response_code
                    ];
            } else {
                list($response, $response_code) = $binding_service::handle($request, $api_version);
            }
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
        return response()->json($response, $response_code);
    }
}
