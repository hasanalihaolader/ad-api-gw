<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait HttpClient
{
    /**
     * Http Request using Guzzle Http
     *
     * @param string $base_url MS Base URL
     * @param array $request_data Post data
     * @param string $request_endpoint MS hit point
     * @param string $request_type Request type
     * @param array $custom_headers
     *
     * @return \Psr\Http\Message\ResponseInterface $response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function httpRequest(
        string $base_url,
        array $request_data,
        string $request_endpoint,
        string $request_type = "POST",
        array $custom_headers = [],
        string $data_type = ''
    ) {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler);
        $log = [];
        list($class_name, $method_name) = self::getCaller();
        $start_time = 0;

        // request middleware
        $stack->push(Middleware::mapRequest(
            function (RequestInterface $request) use (
                &$log,
                &$start_time,
                &$base_url,
                &$request_endpoint,
                &$request_data,
                &$custom_headers
            ) {
                $log['request'] = [
                    'uri' => $base_url . $request_endpoint,
                    'method' => $request->getMethod(),
                    'body' => $request_data,
                    'headers' => $custom_headers
                ];
                $start_time = microtime_int();
                return $request;
            }
        ));

        // response middleware
        $stack->push(Middleware::mapResponse(
            function (ResponseInterface $response) use (
                &$log,
                &$start_time,
                &$class_name,
                &$method_name
            ) {
                $body = $response->getBody()->getContents();
                $json_body = json_decode($body, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $json_body = $body;
                }
                $log['response'] = [
                    'body' => $json_body,
                    'status' => $response->getStatusCode(),
                ];
                $log['start_time'] = convertToDateTimeString($start_time);
                $log['end_time'] = convertToDateTimeString($end_time = microtime_int());
                $log['total_time'] = $end_time - $start_time;

                if ($response->getStatusCode() >= 400) {
                    errorLog($class_name . '@' . $method_name, 'Guzzle Error Response', $log);
                } else {
                    infoLog($class_name . '@' . $method_name, 'Guzzle Success Response', $log);
                }

                $body = \GuzzleHttp\Psr7\stream_for($body);
                return $response->withBody($body);
            }
        ));

        $client = new Client([
            'base_uri' => $base_url,
            'verify' => false,
            'handler' => $stack
        ]);
        $headers = [
            'Service-Id' => config('app.service_id'),
            'Service-Key' => config('app.service_key'),
        ];

        $headers = array_merge($headers, $custom_headers);
        if (($request_type == "POST" || $request_type == "PATCH") && $data_type == '') {
            $response = $client->request($request_type, $request_endpoint, [
                'headers' => $headers,
                'form_params' => $request_data,
            ]);

        } elseif (($request_type == "POST" || $request_type == "PATCH") && $data_type == 'json') {
            $response = $client->request($request_type, $request_endpoint, [
                'headers' => $headers,
                'json' => $request_data,
            ]);

        } elseif ($request_type == "GET") {

            $response = $client->request($request_type, $request_endpoint, [
                'headers' => $headers,
                'query' => $request_data
            ]);
        }

        return $response;
    }

    /**
     * Get class name & method name
     * @return array
     */
    private static function getCaller()
    {
        $trace = debug_backtrace();
        $method_name = "";
        $class_name = "";
        if (isset($trace[2])) {
            $method_name = $trace[2]['function'];
            $class_name = $trace[2]['class'];
            $rc = new \ReflectionClass($class_name);
            $class_name = $rc->getShortName();
        }
        return [
            $class_name, $method_name
        ];
    }
}
