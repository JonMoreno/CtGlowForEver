<?php 
namespace App\Repositories;

use App\Repositories\Composites\MedicalRecordComposite;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;


class MedicalRecordRepository implements MedicalRecordRepositoryInterface
{
    /**
     * Medical composite repository.
     *
     * @var MedicalRecordRepositoryInterface 
     */
    protected $composite;
    
    /**
     * Inject necessary dependency.
     *
     * @param MedicalRecordComposite $medicalComposite
     */
    public function __construct(MedicalRecordComposite $composite)
    {
        $this->medicalComposite = $composite;
    }
    
    /**
     * Retrieve all associated models belonging to the medical model.
     * 
     * @param String $id
     * @return \App\Repositories\Composites\MedicalRecordComposite
     */
    public function find($id)
    {
        return $this->medicalComposite->assemble($id);
        
    }
    
    
}
