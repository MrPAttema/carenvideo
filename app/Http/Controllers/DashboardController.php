<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('CheckToken');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $token = session()->get('carenUserToken');
        $userCareGivers = $token->_embedded->person->_links->care_givers->href;

        $baseUrl = 'https://www.carenzorgt.nl/api/v1' . $userCareGivers;

        $authToken = session()->get('carenAuthToken');
        
        $headr = array();
        $headr[] = 'Content-length: 0';
        $headr[] = 'Accept: application/json';
        $headr[] = 'Authorization: Bearer '. $authToken;

        $curl = curl_init( $baseUrl );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headr );
        $response = json_decode(curl_exec($curl));
        curl_close( $curl );
        
        return view('dashboard', compact('response'));
    }
}
