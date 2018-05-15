<?php 
namespace App\Repositories;

use App\Client\Client;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\ClientRepositoryInterface;


class ClientRepository implements ClientRepositoryInterface
{
    
    /**
     * Retrieve all client models.
     *
     * @return App\Client\Client
     */
    public function all()
    {
        return Client::orderBy('id','desc')->simplePaginate(25);

    }
    
    /**
     * Find all allegie models where this medical id is found.
     *
     * @param String $medical_id
     * @return App\Client\Client
     */
    public function find($id)
    {
        return Client::find($id);

    }
    
    /**
     * Save a new client model with the disired data.
     *
     * @param App\Http\Requests\ClientPost $data
     * @return Boolean
     */
    public function save($request)
    {
        $request->hasFile('file') ? 
        $this->storeImage($request) : '';

        $client = new Client();
        $values = $request->all();        
        foreach ($values as $field => $input) {
            if($field != 'file'){
                $client->{$field} = $input;
            }
        }
        $client->save(); 

        return $client->id;

    } 

    /**
     * Update client model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\ClientPost $data
     * @return Boolean 
     */
    public function update($id, $request)
    {  
        $request->hasFile('file') ? $this->storeImage($request) : '';
        $client = Client::find($id); 
        $values = $request->all(); 
        foreach($values as $field => $input){
            if($field != 'file'){  
                $client->{$field} = $input;
                $client->save();
            }
        }
        $returns = [
            'updated_at' => $client->updated_at,
            'image' =>  $client->image,
        ];
        return collect($returns);
    
    }   
    
    /**
     * Update client model with the following id and data.
     *
     * @param String $id
     * @param App\Http\Requests\ClientPost $data
     * @return Boolean 
     */
    public function delete($id)
    {
        return Client::destroy($id); 

    }


    /**
     * Store model's actual image.
     *
     * @param App\Http\Requests\ClientPost $request
     * @return void
     */
    public function storeImage($request) 
    {
        \Image::make(
            $request->file('file')
            )->orientate()
            ->resize(225,225)
            ->save(base_path('/public/storage/').$request->input('image'));
            
    }

    /**
     * Perform a raw sql query and return any matching models.
     *
     * @param \Request $string
     * @return void
     */
    public function search($string) 
    {   
        $name = explode(" " ,ltrim($string));
        $size = count($name) - 1;

        if($size > 0){
            $first = $name[0]; $last = $name[1];
            //psql
            $query = \DB::select( "SELECT id, first_name || ' ' || last_name AS fullname FROM clients WHERE first_name ILIKE ('$first%') OR last_name ILIKE ('$last%') LIMIT 25;");
            
            //mysql
            // $query = \DB::select(
            //     " select * from clients where first_name like '$first%' or last_name like '$last%' "
            // );
        }else{
            $firstOrLast = $name[0];
            //psql
            $query = \DB::select( "SELECT id, first_name || ' ' || last_name AS fullname FROM clients WHERE first_name ILIKE ('$firstOrLast%') OR last_name ILIKE ('$firstOrLast%') LIMIT 25;");
            
            //msyql
            // $query = \DB::select(
            //     " select * from clients where first_name like '$firstOrLast%' or last_name like '$firstOrLast%' "
            // );
        }

        $ids = [];
        foreach($query as $object){
            foreach($object as $prop => $val){
                if($prop == 'id'){
                    array_push($ids ,  $val);
                }
            }
        }
        return Client::find($ids);

    }  
}