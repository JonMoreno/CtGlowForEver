<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicationPost;
use App\Repositories\Contracts\MedicationRepositoryInterface;

class MedicationController extends Controller
{
    /**
     * Medication repository.
     *
     * @var MedicationRepositoryInterface 
     */
    protected $medications;
    
    /**
     * Medication model repository layer.
     *
     * @param MedicationRepositoryInterface $allergie
     * @return void
     */
    public function __construct(MedicationRepositoryInterface $medication)
    {
        $this->middleware('auth');
        $this->medications = $medication;

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Client\Medication
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\MedicationPost $request
     * @return App\Repositories\MedicationRepository
     */
    public function store(MedicationPost $request)
    {
        return $this->medications->save($request);
     
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\MedicationRepository
     */
    public function show($medical_id)
    {
        return $this->medications->where($medical_id);

    }
    
    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\MedicationPost $request
     * @return App\Repositories\MedicationRepository
     */
    public function update($medical_id, MedicationPost $request)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\MedicationRepository
     */
    public function destroy($id)
    {
        return $this->medications->delete($id);
       
    }  
}
