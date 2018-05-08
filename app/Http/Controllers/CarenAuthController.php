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
use Pusher\Pusher;
use App\Events\UserOnline;

class CarenAuthController extends Controller
{
    private $redirectUri = 'http://localhost:8888/caren/auth/callback';
    
    public function sendCarenAuthRequest(Request $request) {
        
        $clientID = env('CAREN_CLIENT_ID');
        $responseType = 'code';
        $scopes = array('user.read', 'calendar.read', 'care_givers.read');
        $scope = implode("+", $scopes);   
        
        $url = "https://www.carenzorgt.nl/login/oauth/authorize?client_id=".$clientID."&redirect_uri=".$this->redirectUri."&scope=".$scope."&response_type=code";
        
        // dd($url);

        return redirect($url);
    }

    public function getCarenAuthCallback(Request $request) {

        $clientID = env('CAREN_CLIENT_ID');
        $clientSecret = env('CAREN_CLIENT_SECRET');
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
        
        // $response['_embedded']['person']['id'] = "TENNIS";
        $userID = $response->_embedded->person->id;
        // $userID = Crypt::encrypt($userID);
        
      
        session()->put('carenUserToken', $response);
        session()->save();
       

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

    public function pusherAuth(Request $request) {

        // $userData = session()->get('carenUserToken');
        // return $userData; exit;
        // $userID = $userData->_embedded->person->id;

        $userID = 1566404;

        $pusherAppKey = env('PUSHER_APP_KEY');
        $pusherAppSecret = env('PUSHER_APP_SECRET');
        $pusherAppID = env('PUSHER_APP_ID');
        
        // $data = Crypt::encrypt($userID);
        if (isset($userID)) {

            $pusher = new Pusher($pusherAppKey, $pusherAppSecret, $pusherAppID);
            $auth = $pusher->socket_auth($request->channel_name, $request->socket_id);

            $callback = str_replace('\\', '', $request->callback);
            header('Content-Type: application/javascript');
            echo($callback . ':' . $auth);

        } else {

            header('', true, 403);
            echo "Forbidden";
        }
    }
}
