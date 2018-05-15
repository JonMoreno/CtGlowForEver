<?php 
namespace App\Repositories;

use App\Client\SkinProduct;
use App\Repositories\Contracts\SkinProductRepositoryInterface;

class SkinProductRepository implements SkinProductRepositoryInterface
{
    /**
     * Retrieve all skin product models.
     *
     * @return App\Client\SkinProduct
     */
    public function all()
    {
        //
    }
    
    /**
     * Find all skin product models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\SkinProduct
     */
    public function where($medical_id)
    {
        return SkinProduct::where('medical_id', $medical_id)->get();

    }
    
    /**
     * Save a new skin product model with the disired data.
     *
     * @param App\Http\Requests\SkinProductPost $data
     * @return Boolean
     */
    public function save($data)
    {
        $product = new SkinProduct();
        $product->medical_id = $data->medical_id;
        $product->name = $data->name;
        return collect($product->save())->toJson();
    }
    
    /**
     * Update skin product model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\SkinProductPost $data
     * @return Boolean 
     */
    public function update($id , $data)
    {
        //

    }
    
    /**
     * Delete a skin product model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return SkinProduct::destroy($id);
    }
    
}