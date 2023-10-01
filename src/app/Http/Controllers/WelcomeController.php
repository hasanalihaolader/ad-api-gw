<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class WelcomeController extends ApiController
{
    public function welcome()
    {
        return responseData(
            true,
            Response::HTTP_OK,
            'ad group apigw is live',
            []
        );
    }
}
