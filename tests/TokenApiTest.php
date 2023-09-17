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
                "email" => "rahibhasan689009@gmail.com",
                "password" => "12345678"
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
