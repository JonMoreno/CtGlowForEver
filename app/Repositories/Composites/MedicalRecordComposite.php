<?php 
namespace App\Repositories\Composites;

use App\Client\Client;
use App\Client\Medical;

class MedicalRecordComposite
{
    protected $medicalRecord;
    
    /**
     * Retrieve associated client model.
     * 
     * @param int $id
     * @return \App\Client\Client
     */
    public function client($id)
    {
       $client =  Client::find($id);
        return [
            'reference' => $client->id,
            'name' => $client->first_name.' '.$client->last_name,
        ];
        
    }
    
    /**
     * Retrieve medical model.
     * 
     * @param int $id
     * @return \App\Client\Medical
     */
    public function medical($id)
    {
        return Client::find($id)->medical;

    }
    
    /**
     * Retrieve associated surgery model.
     * 
     * @param int $id
     * @return \App\Client\Surgery
     */
    public function surgeries($id)
    {
        return Medical::find($id)->surgeries;
        
    }

    public function stressLevels($id)
    {
        $medical =  Medical::find($id);

        $stress = $medical->stressLevels;
        return $stress;

    }
    
    /**
     * Retrieve associated illness model. 
     *
     * @param int $id
     * @return \App\Client\SkinProduct
     */
    public function illnesses($id)
    {
        return Medical::find($id)->illnesses;
        
    }
    
    /**
     * Retrieve associated allergy model.
     * 
     * @param int $id
     * @return \App\Client\Allergie
     */
    public function allergies($id)
    {        
        return Medical::find($id)->allergies;
        
    }
    
    /**
     * Retrieve associated medication model.
     * 
     * @param int $id
     * @return \App\Client\Medication
     */
    public function medications($id)
    {
        return Medical::find($id)->medications;
    }
    
    /**
     * Retrieve associated skin product model.
     * 
     * @param int $id
     * @return \App\Client\SkinProduct
     */
    public function skinProducts($id)
    {
        return Medical::find($id)->skinProducts;
        
    }
    
    
    /**
     * Assemble all associated models of this medical record.
     * Only if a medical record exitst then fetch its relationships.
     * 
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function assemble($id) 
    { 
        
        $medical = Client::find($id)->medical;
         
        if(!is_null($medical)) {
            return ( collect([
                'client' => $this->client($medical->client_id),
                'medical' => $this->medical($medical->client_id),
                'stressLevels' => $this->stressLevels($medical->id),
                'surgeries' => $this->surgeries($medical->id),
                'illnesses' => $this->illnesses($medical->id),
                'allergies' => $this->allergies($medical->id),
                'medications' => $this->medications($medical->id),
                'skinProducts' => $this->skinProducts($medical->id),
            ]));

        }else{
            $client = Client::find($id);
            return collect( [
                'client' => [
                    'reference' => $client->id,
                    'name' => $client->first_name.' '.$client->last_name,
                ],
                'medical' => '',
                'stressLevels' => '',
                'surgeries' => '',
                'illnesses' => '',
                'allergies' => '',
                'medications' => '',
                'skinProducts' => ''
            ]);

        }

    }

}



