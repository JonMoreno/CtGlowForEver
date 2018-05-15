<?php 
namespace App\Repositories;

use App\Client\Products\Treatment;
use App\Repositories\Contracts\TreatmentRepositoryInterface;

class TreatmentRepository implements TreatmentRepositoryInterface
{
    /**
     * Retrieve all treatment models.
     *
     * @return App\Client\Treatments\Treatment
     */
    public function all()
    {
        return Treatment::orderBy('id','desc')->get();
        
    } 

    /** 
     * Save new treatment model.
     *
     * @param \Request $request
     * @return App\Client\Products\Treatment
     */
    public function save($request)
    {
        $treatment = new Treatment();
        $treatment->name = $request->name;
        $treatment->price = $request->price;
        $treatment->save();

        return $treatment;
    } 

    /**
     * Update specified treatment model.
     *
     * @param \Request $data
     * @param String $id
     * @return String
     */
    public function update($data, $id)
    {
        $request = $data->all();
        
        $treatment = Treatment::find($id);
        foreach($request as $property => $value){
            $treatment->{$property} = $value;
            $treatment->save();
        }
        return (Treatment::find($id))->updated_at;
    }

    /**
     * Soft delete specified treatment model.
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        return Treatment::destroy($id);
    }

    /**
     * Perform a raw sql query and return any matching models.
     *
     * @param \Request $query
     * @return App\Client\Products\Treatment
     */
    public function search($query)
    {
        if(strlen($query) >= 1){
            $results = \DB::select(
                " select * from treatments where name like '%$query%'"
            );
            $ids = [];
            foreach ($results as $result) {
                foreach($result as $key => $val){
                    if($key == 'id'){
                        array_push($ids, $val);
                    }
                }
            }
            return Treatment::find($ids);
        }
    }
}

