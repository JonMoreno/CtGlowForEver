<?php 
namespace App\Repositories;

use App\Client\Illness;
use App\Repositories\Contracts\IllnessRepositoryInterface;


class IllnessRepository implements IllnessRepositoryInterface
{
    /**
     * Retrieve all illness models.
     *
     * @return App\Client\Illness
     */
    public function all()
    {
        //
    }
    
    /**
     * Find all illness models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\Illness
     */
    public function where($medicatl_id)
    {
        return Illness::where('medical_id', $medicatl_id)->get();

    }
    
    /**
     * Save a new illness model with the disired data.
     *
     * @param App\Http\Requests\IllnessPost $data
     * @return Boolean
     */
    public function save($data)
    {
        $illness = new Illness();
        $illness->name = $data->name;
        $illness->medical_id = $data->medical_id;
        return collect($illness->save())->toJson();
        
    }
    
    /**
     * Update illness model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\IllnessPost $data
     * @return Boolean 
     */
    public function update($id , $data)
    {
        //

    }
    
    /**
     * Delete a illness model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return Illness::destroy($id);

    }
}