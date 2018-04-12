<?php

/**
 * [...]
 * Deze controller bevat functies voor het
 * autoriseren met de Carenzorgt API.
 * We zorgen hier ook voor sessie beheer.
 * 
 * @author  Patrick Attema
 * @version V0.3.0 11-04-2018
 * @since   V0.1
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp;

class CarenAuthController extends Controller
{
    private $clientID = '26e3717a35f9de0e7d2e9d4f435b740275edae462ef6677573ea312b70d42e6b';
    private $redirectUri = 'https://carenvideo.test/caren/auth/callback';

    public function sendCarenAuthRequest(Request $request) {

        $responseType = 'code';
        $scopes = array('user.read', 'calendar.read');
        $scope = implode("+", $scopes);   
        
        $url = "https://www.carenzorgt.nl/login/oauth/authorize?client_id=".$this->clientID."&redirect_uri=".$this->redirectUri."&scope=".$scope."&response_type=code";
        
        return redirect($url);
    }

    public function getCarenAuthCallback(Request $request) {

        $clientSecret = 'dad1f2b8685011b8095de778863a5c247ccea0a8e92ca6f8a0fee99207777571';
        $authCode = $request->code;

        $url = "https://www.carenzorgt.nl/oauth/token?client_id=".$this->clientID."&client_secret=".$clientSecret."&grant_type=authorization_code&code=".$authCode."&redirect_uri=".$this->redirectUri."";

        $params = [
            'client_id' => $this->clientID,
            'client_secret' => $clientSecret,
            'authorization_code' => $authCode,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
        ];

        $client = new GuzzleHttp\Client;
        $accessTokenResponse = $client->request('POST', $url, []);
        $accessToken = json_decode($accessTokenResponse->getBody()->getContents(),true)['access_token'];

        $request->session()->put('carenAuthToken', $accessToken);
        $request->session()->save();

        return $this->checkCarenAccountType();
    }

    private function checkCarenAccountType() {

        $url = 'https://www.carenzorgt.nl/api/v1/user';
        $token = session()->get('carenAuthToken');

        $headr = array();
        $headr[] = 'Content-length: 0';
        $headr[] = 'Accept: application/json';
        $headr[] = 'Authorization: Bearer '. $token;

        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headr );
        $response = json_decode(curl_exec($curl));
        curl_close( $curl );
        
        session()->put('carenUserToken', $response);
        session()->save();
       
        if ($response->_embedded->person->owner_id == null) {
            
            return redirect('/dashboard');

        } else {
            
            return redirect('/setup/client');
            
        }

    }

    public function destroySession(Request $request) {

        $request->session()->forget('carenAuthToken');
        $request->session()->forget('carenUserToken');
        $request->session()->flush();
        return redirect('/');
    }
}
