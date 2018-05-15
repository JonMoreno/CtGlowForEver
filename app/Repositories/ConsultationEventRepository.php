<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Client\Client;
use App\Client\Calendar\ConsultationEvent;
use App\Repositories\Contracts\ConsultationEventRepositoryInterface;

class ConsultationEventRepository implements ConsultationEventRepositoryInterface
{
    /**
     * Retrieve all models.
     *
     * @return App\Client\Calendar\ConsultationEvent;
     */
    public function all()
    {
        return (ConsultationEvent::with('client'))->get();
    }

    /**
     * Store new model.
     *
     * @param \Request $request
     * @return App\Client\Calendar\ConsultationEvent
     */
    public function save($request)
    {
        // Create event.
        $event = new ConsultationEvent();
        $event->client_id = $request->client_id;
        $event->time = $request->time;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->save();
        // Return created event.
        $newEvent = ConsultationEvent::find($event->id);
        $newEvent->client;
        return $newEvent;
    }

    /**
     * Update full model in storage where id matches.
     *
     * @param in $id
     * @param \Request
     * @return void
     */
    public function updateFull($id, $data)
    {
        $request = $data;
        
        $event = ConsultationEvent::find($id);
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->description = $request->input('description');
        $event->save(); 
    
    }
    /**
     * Update partial model in storage where id matches.
     *
     * @param in $id
     * @param \Request
     * @return void
     */
    public function updatePartial($id, $data)
    {
        $request = $data->all();

        
        foreach ($request as $input => $value) {
            $event = ConsultationEvent::find($id);
            $event->{$input} = $value;
            $event->save(); 
        }
        return (ConsultationEvent::find($id))->updated_at;

    }

    /**
     * Delete model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return ConsultationEvent::destroy($id);
    }

    /**
     * Return all models with property date
     * as today's date.
     *
     * @return ConsultationEvent
     */
    public function eventsByDay($dayRequest)
    {
        //create a wrapper collection.
        $collection = collect();
        //get related clients by date
        $GLOBALS['consultationRequestDay'] = $dayRequest;
        $clients = Client::whereHas('consultation_events', function ($query) { 
            global $consultationRequestDay;
            $query->where('date', $consultationRequestDay);

        })->get();
       
        //get events for the same date.
        $events =  ConsultationEvent::where('date', $dayRequest)->get(); 

        //combine both collections.
        $collection->push(['reminders' => $events ]);
        $collection->push(['clients' => $clients]);

        return $collection->all();
    }
}