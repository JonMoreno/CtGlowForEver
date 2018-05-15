<?php
namespace App\Repositories;

use App\Client\Calendar\CustomEvent;
use App\Repositories\Contracts\CustomEventRepositoryInterface;

class CustomEventRepository implements CustomEventRepositoryInterface
{

    /**
     * Return all models.
     *
     * @return void
     */
    public function all()
    {
        return CustomEvent::all();
    }

    /**
     * Store new model.
     *
     * @param \Request $request
     * @return App\Client\Calendar\CustomEvent
     */
    public function save($request)
    {
        // Create event.
        $event = new CustomEvent();
        $event->title = $request->title;
        $event->time = $request->time;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->save();
        // Return created event.
        $newEvent = CustomEvent::find($event->id);
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
        
        $event = CustomEvent::find($id);
        $event->title = $request->input('title');
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
            $event = CustomEvent::find($id);
            $event->{$input} = $value;
            $event->save(); 
        }

    }

    /**
     * Delete model with the following id.
     *
     * @param String $id
     * @return Boolean
     */
    public function delete($id)
    {
        return CustomEvent::destroy($id);
    }

    /**
     * Return all models with property date
     * as today's date.
     *
     * @return CustomEvent
     */
    public function eventsByDay($dayRequest)
    {
        $collection = collect();
        $events =  CustomEvent::where('date', $dayRequest)->get(); 
        return $collection->push(['reminders' => $events]);
    }
}