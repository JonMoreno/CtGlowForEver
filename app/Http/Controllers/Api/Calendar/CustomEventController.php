<?php

namespace App\Http\Controllers\Api\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CustomEventRepositoryInterface;

class CustomEventController extends Controller
{
    /**
     * Custom Events repository.
     *
     * @var object
     */
    protected $events;


    /**
     * Inject Custom Events Repository upon instatiation.
     *
     * @param CustomEventRepositoryInterface $events
     */
    public function __construct(CustomEventRepositoryInterface $events)
    {
        $this->middleware('auth');
        $this->events = $events;
    }

    /**
     * Output all Custom Event models in storage.
     *
     * @return CustomEventRepositoryInterface
     */
    public function index()
    {
        return $this->events->all();
    }

    /**
     * After quick validation store new model in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  CustomEventRepositoryInterface
     */
    public function store(Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'title' => 'required|string',
            'time' => ['nullable', "regex:$militaryRegex"],
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);
        return $this->events->save($request); 
    }

    /**
     * Update the specified model in storage.
     * 
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function putUpdate($id, Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'title' => 'required|string',
            'time' => ['nullable', "regex:$militaryRegex"],
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);
        $this->events->updateFull($id, $request); 
    }

    /**
     * Update the specified model in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function patchUpdate($id, Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'title' => 'sometimes|required|string',
            'time' => ['sometimes','nullable', "regex:$militaryRegex"],
            'date' => 'sometimes|required|date',
            'description' => 'sometimes|nullable|string'
        ]);
        $this->events->updatePartial($id, $request);
    }

    /**
     * Remove the specified model from storage.
     *
     * @param  int  $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->events->delete($id);
    }

    /**
     * Retrieve all custom event models
     * with today's date.
     *
     * @return CustomEventRepository
     */
    public function reminders($day)
    {
        return $this->events->eventsByDay($day);
    }
}
