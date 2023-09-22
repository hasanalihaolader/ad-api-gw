<?php

namespace App\Services;

use App\Models\AuditTrail;
use App\Repositories\AuditTrailRepository;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Response;

class AuditTrailService
{
    public static function track(
        int $user_id,
        string $event,
        string $model,
        array $data
    ): void {
        try {
            AuditTrailRepository::create([
                AuditTrail::USER_ID => $user_id,
                AuditTrail::EVENT => $event,
                AuditTrail::FEATURE => $model,
                AuditTrail::DATA => json_encode($data),
            ]);
        } catch (RequestException $e) {
            $response = responseData(
                false,
                Response::HTTP_BAD_REQUEST,
                Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                [],
                $e->getMessage()
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                $response
            );
        } catch (Exception $e) {
            $response = responseData(
                false,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [],
                $e->getMessage()
            );
            errorLog(
                __METHOD__,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                $response
            );
        }
    }
}
