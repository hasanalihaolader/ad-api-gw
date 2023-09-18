<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);
            $credentials = $request->only(['email', 'password']);
            if (!$token = Auth::attempt($credentials)) {
                return response()->json(responseData(
                    false,
                    Response::HTTP_UNAUTHORIZED,
                    'Unauthorized'
                ));
            }
            $response = responseData(
                true,
                Response::HTTP_OK,
                'Token get successfully',
                $this->respondWithToken($token)
            );
            infoLog(__METHOD__, 'Token get successfully', $response);
            //TODO: have improvement scope during write log sensitive information not write directly use *********** symbol instead
        } catch (\Exception $e) {
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
        return response()->json($response);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        try {
            $response = responseData(
                true,
                Response::HTTP_OK,
                'Logged in user profile fetch successfully',
                auth()->user()
            );
        } catch (\Exception $e) {
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
        return response()->json($response);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            auth()->logout();
            $response = responseData(
                true,
                Response::HTTP_OK,
                'Successfully logged out'
            );
            infoLog(__METHOD__, 'Successfully logged out', []);
        } catch (\Exception $e) {
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
        return response()->json($response);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        try {
            $response = responseData(
                true,
                Response::HTTP_OK,
                'Refresh token get successfully',
                $this->respondWithToken(
                    auth()->refresh()
                )
            );
        } catch (\Exception $e) {
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
        return response()->json($response);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ];
    }
}
