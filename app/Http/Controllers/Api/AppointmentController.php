<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ConsultationRepositoryInterface;

class AppointmentController extends Controller
{
    /**
     * Events Repository.
     *
     * @var object
     */
    protected $events;

    /**
     * Inject upon instantiation consultation events repository.
     *
     * @param ConsultationRepositoryInterface $events
     */
    public function __construct(ConsultationRepositoryInterface $events)
    {
        $this->middleware('auth');
        $this->events = $events;
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function update($id, Request $request)
    {
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        $request->validate([
            'time' => ['sometimes','nullable', "regex:$militaryRegex"],
            'date' => 'sometimes|required|date',
            'description' => 'sometimes|nullable|string'
        ]);
        return $this->events->updatePartial($id, $request);
    }
}
