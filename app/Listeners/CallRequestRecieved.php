<?php

namespace App\Listeners;

use App\Events\SendCallRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallRequestRecieved
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendCallRequest  $event
     * @return void
     */
    public function handle(SendCallRequest $event)
    {
        return view('call.recieving');
    }
}
