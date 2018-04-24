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
use Event;
use App\Events\UserOnline;

class CarenAuthController extends Controller
{
    private $redirectUri = 'https://carenvideo.test/caren/auth/callback';
    
    public function sendCarenAuthRequest(Request $request) {
        
        $clientID = env('caren_client_id');
        $responseType = 'code';
        $scopes = array('user.read', 'calendar.read');
        $scope = implode("+", $scopes);   
        
        $url = "https://www.carenzorgt.nl/login/oauth/authorize?client_id=".$clientID."&redirect_uri=".$this->redirectUri."&scope=".$scope."&response_type=code";
        
        return redirect($url);
    }

    public function getCarenAuthCallback(Request $request) {

        $clientID = env('caren_client_id');
        $clientSecret = env('caren_client_secret');
        $authCode = $request->code;

        $url = "https://www.carenzorgt.nl/oauth/token?client_id=".$clientID."&client_secret=".$clientSecret."&grant_type=authorization_code&code=".$authCode."&redirect_uri=".$this->redirectUri."";

        $params = [
            'client_id' => $clientID,
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
       
        $userID = $response->_embedded->person->id;

        if ($response->_embedded->person->owner_id == null) {
            
            Event::fire(new UserOnline($userID));
            return redirect('/dashboard');
            
        } else {
            
            Event::fire(new UserOnline($userID));
            return redirect('/setup/client');
        }

    }

    public function destroySession(Request $request) {

        $request->session()->forget('carenAuthToken');
        $request->session()->forget('carenUserToken');
        $request->session()->flush();
        return redirect('/');
    }

    public function pusherAuth() {

        global $user;
        if ($user->uid) {

            $presence_data = array('name' => $user->name);
            echo $pusher->presence_auth($_POST['channel_name'], $_POST['socket_id'], $user->uid, $presence_data);

        } else {

            header('', true, 403);
            echo( "Forbidden" );
        }
    }
}
