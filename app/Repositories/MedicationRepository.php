<?php 
namespace App\Repositories;

use App\Client\Medication;
use App\Repositories\Contracts\MedicationRepositoryInterface;

class MedicationRepository implements MedicationRepositoryInterface
{
    /**
     * Retrieve all medication models.
     *
     * @return App\Client\Medication
     */
    public function all()
    {
        //
        
    }
    
    /**
     * Find all medication models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\Medication
     */
    public function where($medical_id)
    {
        return Medication::where('medical_id', $medical_id)->get();
        
    }
    
    /**
     * Save a new medication model with the disired data.
     *
     * @param App\Http\Requests\MedicationPost $data
     * @return Boolean
     */
    public function save($input)
    {
        $medication = new Medication();
        $medication->medical_id = $input->medical_id;
        $medication->name = $input->name;
        $medication->withdrawal_period = $input->withdrawal_period;
        return collect($medication->save())->toJson();
        
    }
    
    /**
     * Update medication model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\MedicationPost $data
     * @return Boolean 
     */
    public function update($id , $data)
    {
        //

    }
    
    /**
     * Delete a medication model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return Medication::destroy($id);
        
    } 
}

