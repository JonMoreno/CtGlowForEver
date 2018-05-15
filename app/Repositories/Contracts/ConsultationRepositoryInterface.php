<?php
namespace App\Repositories\Contracts;


interface ConsultationRepositoryInterface 
{
    public function findAll($ref);
    
    public function save($data);

    public function update($ref , $data);
}