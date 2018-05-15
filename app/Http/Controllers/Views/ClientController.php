<?php

namespace App\Http\Controllers\Views;

use App\Http\Requests\ClientPost; 
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ClientRepositoryInterface;


class ClientController extends Controller
{
    /**
     * Clients repository.
     *
     * @var ClientRepositoryInterface
     */
    protected $client;
    
    /**
     * Client model repository layer.
     *
     * @param ClientRepositoryInterface $client
     * @return void
     */
    public function __construct(ClientRepositoryInterface $client)
    {
        $this->client = $client;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Resources\Views\Client\clients
     */
    public function index()
    {   
        return view('client.clients');
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Resources\Views\Client\create_client
     */
    public function create()
    { 
        return view('client.create_client');
    
    }
     
    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return Resources\Views\Client\show_client
     */
    public function show($id)
    {
        $client = $this->client->find($id);
        return view('client.show_client', compact('client'));
    }      
}
