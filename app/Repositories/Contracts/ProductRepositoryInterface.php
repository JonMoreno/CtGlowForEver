<?php 
namespace App\Repositories\Contracts;

interface ProductRepositoryInterface 
{
    public function all();
    
    public function save($data);

    public function update($data, $ref);
    
    public function search($query);

}