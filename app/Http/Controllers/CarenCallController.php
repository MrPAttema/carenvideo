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

use Illuminate\Http\Request;

class CarenCallController extends Controller
{   
    public function __construct() {
        
        $this->middleware('CheckToken');
    }

    public function sendCallConnectRequest(Request $request) {
            
        
    }

    public function getCallConnectStatus(Request $request) {

        

    }

    public function sendCurrentConnectUid(Request $request) {

        

    }

    public function getCallConnectUid(Request $request) {

        

    }
}
