<?php 
namespace App\Repositories;

use App\Client\Client;
use App\Client\Medical;
use App\Repositories\Contracts\MedicalRepositoryInterface;

class MedicalRepository implements MedicalRepositoryInterface
{
    /**
     * Retrieve all medical models.
     *
     * @return App\Client\Medical
     */
    public function all(){
        // 

    }
    
    /**
     * Find a medical model with this client id.
     *
     * @param String $medical_id
     * @return App\Client\Medical
     */
    public function find($id)
    {
        return Client::find($id)->medical;

    }

    /**
     * Save a new medical model with the disired data.
     *
     * @param App\Http\Requests\MedicalPost $data
     * @return String
     */
    public function save($values)
    {
        $data = $values->all();
        $medical = new Medical();
        foreach( $data as $property => $value) {
            $medical->{$property} = $value;
        }
        $medical->save();

        $collection = collect();
        $collection->push(['reference' => $medical->id]);
        $collection->push(['updated_at' => $medical->updated_at]);
        return $collection;

    }
    
    /**
     * Update medical model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\MedicalPost $data
     * @return Boolean 
     */
    public function update($id, $data)
    {
        $request = $data->all();
        foreach( $request as $property => $value) {
            $medical = Client::find($id)->medical;
            $medical->{$property} = $value;
            $medical->save();
        }
        return (Client::find($id)->medical)->updated_at;

    }
    
    /**
     * Delete a medical model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        //

    }
}