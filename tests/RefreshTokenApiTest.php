<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RefreshTokenApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetRefreshTokenV1ApiSuccessfully()
    {
        $response = $this->post(
            '/api/v1/login',
            [
                "email" => "test@gmail.com",
                "password" => "12345678"
            ]
        );
        $access_token = json_decode($response->response->content(), true)['data']['access_token'];
        $refresh_token_response = $this->post(
            '/api/v1/refresh',
            [
                'Authorization' => 'Bearer ' . $access_token
            ]
        );

        $refresh_token_response->seeStatusCode(200);
        $refresh_token_response->seeJsonStructure(
            [
                'status',
                'code',
                'message',
                'data' =>
                [
                    'access_token',
                    'token_type',
                    'expires_in',
                ]
            ]
        );
        $refresh_token_response->seeJson(
            [
                "status" => true,
                "code" => 200,
                "message" => "Refresh token get successfully",
            ]
        );
    }
}
