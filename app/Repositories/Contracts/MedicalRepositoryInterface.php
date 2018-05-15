<?php 
namespace App\Repositories\Contracts;

interface MedicalRepositoryInterface 
{
    public function all();
    
    public function find($id);
    
    public function save($data);
    
    public function update($id , $data);
    
    public function delete($id);
    
}