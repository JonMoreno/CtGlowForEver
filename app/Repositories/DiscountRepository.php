<?php 
namespace App\Repositories;

use App\Client\Products\Discount;
use App\Repositories\Contracts\DiscountRepositoryInterface;

class DiscountRepository implements DiscountRepositoryInterface
{
    /**
     * Retrieve all discount models.
     *
     * @return App\Client\Treatments\Discount
     */
    public function all()
    {
        return Discount::orderBy('id','desc')->get();
        
    } 

    /** 
     * Save new discount model.
     *
     * @param \Request $request
     * @return App\Client\Products\Discount
     */
    public function save($request)
    {
        $discount = new Discount();
        $discount->name = $request->name;
        $discount->discount_type = $request->discount_type;
        $discount->discount_value = $request->discount_value;
        $discount->save();
        return $discount;
    } 

    /**
     * Update specified discount model.
     *
     * @param \Request $data
     * @param String $id
     * @return String
     */
    public function update($data, $id)
    {
        $request = $data->all();
        
        $discount = Discount::find($id);
        foreach($request as $property => $value){
            $discount->{$property} = $value;
            $discount->save();
        }
        return Discount::find($id)->updated_at;
    }

    /**
     * Soft delete specified discount model.
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        return Discount::destroy($id);
    }

    /**
     * Perform a raw sql query and return any matching models.
     *
     * @param \Request $query
     * @return App\Client\Products\Discount
     */
    public function search($query)
    {
        if(strlen($query) >= 1){
            $results = \DB::select(
                " select * from discounts where name like '%$query%'"
            );
            $ids = [];
            foreach ($results as $result) {
                foreach($result as $key => $val){
                    if($key == 'id'){
                        array_push($ids, $val);
                    }
                }
            }
            return Discount::find($ids);
        }
    } 
}

