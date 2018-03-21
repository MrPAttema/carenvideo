<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {

        return view('welcome', compact('groups', 'conversations'));
    }

    public function setConnection(Request $request) {

        Chat::startConversationWith($request->userID);

    }
}


