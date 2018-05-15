<?php 
namespace App\Repositories;

use App\Client\Allergie; 
use App\Repositories\Contracts\AllergieRepositoryInterface;

  
class AllergieRepository implements AllergieRepositoryInterface
{

    /**
     * Retrieve all allergie models.
     *
     * @return App\Client\Allergie
     */
    public function all()
    {
        // 
    }
    
    /**
     * Find all allegie models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\Allergie
     */
    public function where($medical_id)
    {
        return Allergie::where('medical_id', $medical_id)->get(); 

    }
    
    /**
     * Save a new allergie model with the disired data.
     *
     * @param App\Http\Requests\AllergiePost $data
     * @return Boolean
     */
    public function save($data)
    {
        $allergie = new Allergie();
        $allergie->name = $data->name;
        $allergie->medical_id = $data->medical_id;
        return collect($allergie->save())->toJson();
        
    }
    
    /**
     * Update allergie model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\AllergiePost $data
     * @return Boolean 
     */
    public function update($id, $data)
    {
        //

    }

    /**
     * Delete a allergie model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return Allergie::destroy($id);

    }  
}