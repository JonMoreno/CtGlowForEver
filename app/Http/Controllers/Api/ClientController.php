<?php

namespace App\Http\Controllers\Api;

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
        $this->middleware('auth');
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Client\Client
     */
    public function index()
    {
        return $this->client->all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\ClientPost $request
     * @return App\Repositories\ClientRepository
     */
    public function store(ClientPost $request)
    {
        return $this->client->save($request);
        
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\ClientPost $request
     * @return App\Repositories\ClientRepository
     */
    public function update($id , ClientPost $request)
    {
        return $this->client->update($id ,$request);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\ClientRepository
     */
    public function destroy($id)
    {
        $this->client->delete($id);
    }

    /**
     * Search for a model that has a matching first 
     * name or last name.
     * 
     * @param String $name
     * @return App\Client\Client
     */
    public function search($name)
    { 
        return $this->client->search($name);
        
    }    
}
