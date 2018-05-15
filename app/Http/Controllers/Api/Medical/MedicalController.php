<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Requests\MedicalPost;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MedicalRepositoryInterface;


class MedicalController extends Controller
{
    /**
     * Medical repository.
     *
     * @var MedicalRepositoryInterface 
     */
    protected $medical;
    
    /**
     * Medical model repository layer.
     * 
     * @param MedicalRepositoryInterface $medical
     */
    public function __construct(MedicalRepositoryInterface $medical)
    {
        $this->middleware('auth');
        $this->medical = $medical;
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Client\Medical
     */
    public function index()
    {
        //

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\MedicalPost $request
     * @return App\Repositories\MedicalRepository
     */
    public function store(MedicalPost $request)
    {
        return $this->medical->save($request);

    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\MedicalRepository
     */
    public function show($id)
    {
        return $this->medical->find($id);

    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\MedicalPost $request
     * @return App\Repositories\MedicalRepository
     */
    public function update($id, MedicalPost $request)
    {   
        return $this->medical->update($id, $request);
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\MedicalRepository
     */
    public function destroy($id)
    {
        //
        
    }
    

}
