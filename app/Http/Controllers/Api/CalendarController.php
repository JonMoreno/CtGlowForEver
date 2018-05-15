<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CalendarRepositoryInterface;

class CalendarController extends Controller
{

    /**
     * Calendar event repository.
     *
     * @var object
     */
    protected $calendar;

    /**
     * Inject calendar event repository.
     *
     * @param CalendarEventRepositoryInterface $calendar
     */
    public function __construct(CalendarRepositoryInterface $calendar)
    {
        $this->middleware('auth');
        $this->calendar = $calendar;
    }

    /**
     * Fetch listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultations()
    {
        return $this->calendar->consultationEvents();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
