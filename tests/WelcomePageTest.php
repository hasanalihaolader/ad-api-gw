<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WelcomePageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWelcomePage()
    {
        $this->get('/');
        $this->seeJsonEquals(
            [
                "status" => true,
                "code" => 200,
                "message" => "ad group apigw is live",
                "data" => []
            ]
        );
    }
}
