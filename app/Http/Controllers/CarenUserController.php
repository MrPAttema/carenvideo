<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp;

class CarenUserController extends Controller
{
    public function getCarenUserData() {
        
        $url = 'https://carenzorgt.nl/api/v1/user';
        $token = session()->get('token');
        $params = [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        ];

      
          $ch = curl_init( $url );
          curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
          curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
      
          curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
          curl_setopt( $ch, CURLOPT_HTTPHEADER, $params );
      
          $response = curl_exec( $ch );
          $httpStatus = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
          curl_close( $ch );
        


        // $client = new GuzzleHttp\Client;
        // $response = $client->request('POST', $url, [
        //     'headers' => $params
        // ]);

        // $response = json_decode($response->getBody()->getContents(),true);

        dd($response);

    }
}
