<?php 
namespace App\Repositories\Contracts;

interface AllergieRepositoryInterface 
{
    public function all();
    
    public function where($id);
    
    public function save($data);
    
    public function update($id, $data);
    
    public function delete($id);
}