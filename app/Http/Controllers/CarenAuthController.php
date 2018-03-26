<?php

/**
 * [...]
 * Deze controller bevat functies voor het
 * autoriseren met de Carenzorgt API.
 * We zorgen hier ook voor sessie beheer.
 * 
 * @author  Patrick Attema
 * @version V0.2 22-03-2018
 * @since   V0.1
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp;

class CarenAuthController extends Controller
{
   
    public function sendCarenAuthRequest(Request $request) {

        $responseType = 'code';
        $clientID = '26e3717a35f9de0e7d2e9d4f435b740275edae462ef6677573ea312b70d42e6b';
        $redirectUri = 'https://carenvideo.test/caren/auth/callback';
        $scopes = array('user.read', 'calendar.read');    
        $scope = implode("+", $scopes);   
        
        $url = "https://www.carenzorgt.nl/login/oauth/authorize?client_id=".$clientID."&redirect_uri=".$redirectUri."&scope=".$scope."&response_type=code";
        
        return redirect($url);
    }

    public function getCarenAuthCallback(Request $request) {

        $clientID = '26e3717a35f9de0e7d2e9d4f435b740275edae462ef6677573ea312b70d42e6b';
        $clientSecret = 'dad1f2b8685011b8095de778863a5c247ccea0a8e92ca6f8a0fee99207777571';
        $redirectUri = 'https://carenvideo.test/caren/auth/callback';
        $authCode = $request->code;

        $url = "https://www.carenzorgt.nl/oauth/token?client_id=".$clientID."&client_secret=".$clientSecret."&grant_type=authorization_code&code=".$authCode."&redirect_uri=".$redirectUri."";

        $params = [
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
            'authorization_code' => $authCode,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ];

        $client = new GuzzleHttp\Client;
        $accessTokenResponse = $client->request('POST', $url, []);
        $accessToken = json_decode($accessTokenResponse->getBody()->getContents(),true)['access_token'];

        $request->session()->put('token', $accessToken);
        $request->session()->save();

        return redirect('/');
    }

    public function destroySession(Request $request) {

        $request->session()->forget('token');
        $request->session()->flush();
        return redirect('/');
    }
}
