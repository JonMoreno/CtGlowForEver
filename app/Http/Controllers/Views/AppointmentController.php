<?php

namespace App\Http\Controllers\Views;

use \App\Client\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client\Calendar\ConsultationEvent;

class AppointmentController extends Controller
{
    /**
     * Add Controller to the authentication middleware group.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events = 
            ConsultationEvent
            ::where('client_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $client = collect(Client::find($id));


        $response =  collect()->merge(['client' => $client, 'appts' => $events]);

        $response->all();


        return view('calendar.show_appointment', compact('response')); 
    }
}
