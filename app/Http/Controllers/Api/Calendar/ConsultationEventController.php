<?php

namespace App\Http\Controllers\Api\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ConsultationEventRepositoryInterface;

class ConsultationEventController extends Controller
{
    /**
     * Consultation Event Repo.
     *
     * @var object
     */
    protected $events;

    /**
     * Inject Consultation Events Repository.
     *
     * @param ConsultationEventRepositoryInterface $events
     */
    public function __construct(ConsultationEventRepositoryInterface $events)
    {
        $this->middleware('auth');
        $this->events= $events;
    }
    
    /**
     * All listing resources.
     *
     * @return ConsultationEventRepositoryInterface
     */
    public function index()
    {
        return $this->events->all();
    }

   /**
    * After validation store resource in storage.
    *
    * @param Request $request
    * @return boolean
    */
    public function store(Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'client_id' => 'required|integer',
            'time' => ['nullable', "regex:$militaryRegex"],
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);
        return $this->events->save($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function putUpdate($id, Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'time' => ['sometimes','nullable', "regex:$militaryRegex"],
            'date' => 'sometimes|required|date',
            'description' => 'sometimes|nullable|string'
        ]);
        $this->events->updateFull($id, $request);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function patchUpdate($id, Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'time' => ['sometimes','nullable', "regex:$militaryRegex"],
            'date' => 'sometimes|required|date',
            'description' => 'sometimes|nullable|string'
        ]);
        return $this->events->updatePartial($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->events->delete($id);
    }

    /**
     * Retrieve all consulation event models
     * with today's date.
     *
     * @return ConsultationEventRepository
     */
    public function reminders($day)
    {
        return $this->events->eventsByDay($day);
    }
}
