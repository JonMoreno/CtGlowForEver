<?php 
namespace App\Repositories;

use App\Client\Products\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Retrieve all product models.
     *
     * @return App\Client\Products\Product
     */
    public function all()
    {
        return Product::orderBy('id', 'desc')->get();
        
    } 
    
    /** 
     * Save new product model.
     *
     * @param \Request $request
     * @return App\Client\Products\Product
     */
    public function save($request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        return $product;
    }

    /**
     * Update specified product model.
     *
     * @param \Request $data
     * @param String $id
     * @return String
     */
    public function update($data, $id)
    {
        $request = $data->all();
        
        $product = Product::find($id);
        foreach($request as $property => $value){
            $product->{$property} = $value;
            $product->save();
        }
        return (Product::find($id))->updated_at;
    }

    /**
     * Soft delete specified product model.
     *
     * @param [type] $id
     * @return void
     */
    public function delete($id)
    {
        return Product::destroy($id);
    }

    /**
     * Perform a raw sql query and return any matching models.
     *
     * @param \Request $query
     * @return App\Client\Products\Product
     */
    public function search($query)
    {
        if(strlen($query) >= 1){
            $results = \DB::select(
                " select * from products where name like '%$query%'"
            );
            $ids = [];
            foreach ($results as $result) {
                foreach($result as $key => $val){
                    if($key == 'id'){
                        array_push($ids, $val);
                    }
                }
            }
            return Product::find($ids);
        }
    }

}

