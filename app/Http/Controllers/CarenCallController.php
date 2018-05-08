<?php

/**
 * [...]
 * Deze controller bevat functies voor het
 * opzetten van een verbinding tussen twee
 * devices. (e.g. master & client device).
 * 
 * @author  Patrick Attema
 * @version V0.1 25-03-2018
 * @since   V0.1
 */

namespace App\Http\Controllers;

use Event;
use App\Events\SendCallRequest;
use Illuminate\Http\Request;
use Pusher;
use Crypt;


class CarenCallController extends Controller
{         
    public function __construct() {
        
        // $this->middleware('CheckToken');
    }

    public function sendCallConnectRequest(Request $request) {

        $userData = session()->get('carenUserToken');
        $userID = $userData->_embedded->person->id;
        
        $data = Crypt::encrypt($userID);

        Event::fire(new SendCallRequest($data));
        return view('call.waiting');

    }

    public function getCallConnectStatus(Request $request) {

        return $request->userID;

        Event::fire(new SendCallMeta($data));
        return 'Ready';
    }

    public function sendCurrentConnectUid(Request $request) {


    }

    public function getCallConnectUid(Request $request) {

        

    }
}
