<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Client\Client;
use App\Client\Consultation;
use App\Client\Calendar\ConsultationEvent;
use App\Repositories\Contracts\ConsultationRepositoryInterface;

class ConsultationRepository implements ConsultationRepositoryInterface
{

    public function clientsLatest($id)
    {
        $client = Client::find($id);
        $consultation = $client->consultations;
        return (collect($consultation))->last();
    }

    /**
     * Find all models that belong to client model.
     *
     * @param String $id
     * @return App\Client\Consultation
     */
    public function findAll($id) 
    {
        $model = Client::find($id);
        $consultations = ( (collect($model->consultations) )->sortByDesc('id') )->values()->all();

        $client = collect($model)->forget('consultations');
        return collect(((collect($client))->merge(['consultations' => $consultations]))->all());
    }

    /**
     * Save new consultation model for the client.
     *
     * @param App\Http\Requests\ConsultationPost
     * @return App\Client\Consultation
     */
    public function save($request) 
    {        
        $consultation = new Consultation();
        $consultation->client_id = $request->client_id;
        $consultation->notes = $request->notes;
        $consultation->save();

        return $consultation->id;
    } 


    public function update($id, $data) 
    {
        $consultation = Consultation::find($id);

        $values = $data->all();
        foreach ($values as $field => $input) {
            if($field != 'client_id'){
                $consultation->{$field} = $input;
                $consultation->save();
            }
        } 

        return $consultation->updated_at;
    }

}