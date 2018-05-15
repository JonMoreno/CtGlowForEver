<?php 
namespace App\Repositories;

use App\Client\Surgery;
use App\Repositories\Contracts\SurgeryRepositoryInterface;


class SurgeryRepository implements SurgeryRepositoryInterface
{
    /**
     * Retrieve all surgery models.
     *
     * @return App\Client\Surgery
     */
    public function all()
    {
        //
        
    }
    
    /**
     * Find all surgery models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\Surgery
     */
    public function where($medical_id)
    {
        return Surgery::where('medical_id', $medical_id)->get();
        
    }
    
    /**
     * Save a new surgery model with the disired data.
     *
     * @param App\Http\Requests\SurgeryPost $data
     * @return Boolean
     */
    public function save($data)
    {
        $surgery = new Surgery();
        $surgery ->medical_id = $data->medical_id;
        $surgery ->name = $data->name;
        $surgery ->location = $data->location;
        return collect($surgery ->save())->toJson();
        
    }
    
    /**
     * Update surgery model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\SurgeryPost $data
     * @return Boolean 
     */
    public function update($id, $data)
    {
        //

    }
    
    /**
     * Delete a surgery model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return Surgery::destroy($id);
        
    }  
}