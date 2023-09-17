<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LogoutApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetLogoutV1ApiSuccessfully()
    {
        $response = $this->post(
            '/api/v1/login',
            [
                "email" => "test@gmail.com",
                "password" => "12345678"
            ]
        );
        $access_token = json_decode($response->response->content(), true)['data']['access_token'];
        $logout_api_response = $this->post(
            '/api/v1/logout',
            [
                'Authorization' => 'Bearer ' . $access_token
            ]
        );

        $logout_api_response->seeStatusCode(200);
        $logout_api_response->seeJsonStructure(
            [
                'status',
                'code',
                'message',
                'data' => []
            ]
        );
        $logout_api_response->seeJson(
            [
                "status" => true,
                "code" => 200,
                "message" => "Successfully logged out",
            ]
        );
    }
}
