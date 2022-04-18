<?php

namespace App\Http;

use Illuminate\Http\Response;

class JsonResponse extends Response
{
    public function __construct($data = '', int $statusCode = 200, array $headers = [])
    {
        $response = [
            'code' => $statusCode
        ];

        if( $statusCode !== 200 ){
            $response['status'] = 'error';
            $response['errors'] = $data;
        } else {
            $response['status'] = 'success';
            $response['data'] = $data;
        }



        parent::__construct($response, 200, $headers);
    }
}
