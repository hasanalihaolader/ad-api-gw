<?php

namespace App\Http\Controllers;

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
        return response()->json(
            responseData(
                true,
                Response::HTTP_OK,
                'Token get successfully',
                $this->respondWithToken($token)
            )
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        return response()->json(
            responseData(
                true,
                Response::HTTP_OK,
                'Logged in user profile fetch successfully',
                auth()->user()
            )
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(
            responseData(
                true,
                Response::HTTP_OK,
                'Successfully logged out'
            )
        );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json(
            responseData(
                true,
                Response::HTTP_OK,
                'Refresh token get successfully',
                $this->respondWithToken(
                    auth()->refresh()
                )
            )
        );
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ];
    }
}
