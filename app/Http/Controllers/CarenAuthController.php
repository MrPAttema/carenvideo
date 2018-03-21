<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp;

class CarenAuthController extends Controller
{
    public function sendCarenAuthRequest(Request $request) {

        $responseType = 'code';
        $clientID = '26e3717a35f9de0e7d2e9d4f435b740275edae462ef6677573ea312b70d42e6b';
        $redirectUri = 'http://carenvideo.test/caren/auth/callback';
        $scopes = array('user.read', 'calendar.read');    
        $scope = implode("+", $scopes);   
        
        $url = "https://www.carenzorgt.nl/login/oauth/authorize?client_id=".$clientID."&redirect_uri=".$redirectUri."&scope=".$scope."&response_type=code";
        
        return redirect($url);
    }

    public function getCarenAuthCallback(Request $request) {

        $clientID = '26e3717a35f9de0e7d2e9d4f435b740275edae462ef6677573ea312b70d42e6b';
        $clientSecret = 'dad1f2b8685011b8095de778863a5c247ccea0a8e92ca6f8a0fee99207777571';
        $redirectUri = 'http://carenvideo.test/caren/auth/token';
        $authCode = $request->code;

        // $url = "https://www.carenzorgt.nl/oauth/token?client_id=".$clientID."&client_secret=".$clientSecret."&grant_type=authorization_code&code=".$authCode."&redirect_uri=".$redirectUri."";

        $accessTokenUrl = 'https://www.carenzorgt.nl/oauth/token';
        $params = [
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'authorization_code' => $authCode,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ];
        $client = new GuzzleHttp\Client;
        $accessTokenResponse = $client->request('POST', $accessTokenUrl, $params);
        $accessToken = json_decode($accessTokenResponse->getBody()->getContents(),true)['access_token'];
        // dd($accessTokenResponse);
        return $this->getCarenAuthToken($accessToken);
        // return view('welcome');
    }

    public function getCarenAuthToken(Request $request) {

        $request->session()->push('token', $accessToken);

    }
}
