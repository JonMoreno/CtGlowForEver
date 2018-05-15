<?php 
namespace App\Repositories;

use App\Client\StressLevel;
use App\Repositories\Contracts\StressLevelRepositoryInterface;

class StressLevelRepository implements StressLevelRepositoryInterface
{
    /**
     * Retrieve all stressLevel models.
     *
     * @return App\Client\StressLevel
     */
    public function all()
    {
        //
        
    }
    
    /**
     * Find all stressLevel models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\StressLevel
     */
    public function where($medical_id)
    {
        return StressLevel::where('medical_id', $medical_id)->get();
        
    }
    
    /**
     * Save a new stressLevel model with the disired data.
     *
     * @param App\Http\Requests\StressLevelPost $data
     * @return Boolean
     */
    public function save($input)
    {
        $stressLevel = new StressLevel();
        $stressLevel->medical_id = $input->medical_id;
        $stressLevel->stress_level = $input->stress_level;
        return collect($stressLevel->save())->toJson();
        
    }
    
    /**
     * Update stressLevel model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\StressLevelPost $data
     * @return Boolean 
     */
    public function update($id , $data)
    {
        //

    }
    
    /**
     * Delete a stressLevel model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return StressLevel::destroy($id);
        
    } 
}

