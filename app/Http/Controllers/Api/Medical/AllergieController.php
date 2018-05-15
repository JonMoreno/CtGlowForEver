<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Requests\AllergiePost;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AllergieRepositoryInterface;


class AllergieController extends Controller
{
    /**
     * Allergies repository.
     *
     * @var AllergieRepositoryInterface
     */
    protected $allergies;
    
    /**
     * Allergie model repository layer.
     *
     * @param AllergieRepositoryInterface $allergie
     * @return void
     */
    public function __construct(AllergieRepositoryInterface $allergie)
    {
        $this->middleware('auth');
        $this->allergies = $allergie;

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Client\Allergie
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\AllergiePost $request
     * @return App\Repositories\AllergieRepository
     */
    public function store(AllergiePost $request)
    {
        return $this->allergies->save($request);
        
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\AllergieRepository
     */
    public function show($medical_id)
    {
        return $this->allergies->where($medical_id);
        
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\AllergiePost $request
     * @return App\Repositories\AllergieRepository
     */
    public function update($id, AllergiePost $request)
    {
        //
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\AllergieRepository
     */
    public function destroy($id)
    {
       return $this->allergies->delete($id);
        
    }  
}
