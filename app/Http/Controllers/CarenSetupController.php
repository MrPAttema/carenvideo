<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarenSetupController extends Controller
{
    
    public function setupAsClient() {

        return redirect('/dashboard');
        
    }

    public function setupAsMaster() {

        return redirect('/dashboard');
    }

}
