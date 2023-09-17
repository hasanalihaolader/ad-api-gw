<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class WelcomeController extends Controller
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
