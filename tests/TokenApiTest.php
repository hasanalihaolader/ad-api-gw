<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TokenApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetTokenV1ApiSuccessfully()
    {
        $this->post(
            '/api/v1/login',
            [
                "email" => "test@gmail.com",
                "password" => "12345678"
            ]
        );
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
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
        $this->seeJson(
            [
                "status" => true,
                "code" => 200,
                "message" => "Token get successfully",
            ]
        );
    }
}
