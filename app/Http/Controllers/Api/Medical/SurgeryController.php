<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Requests\SurgeryPost;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SurgeryRepositoryInterface;


class SurgeryController extends Controller
{
    /**
     * Surgery repository.
     *
     * @var SurgeryRepositoryInterface
     */
    protected $surgery;
  
    /**
     * Surgery model repository layer.
     *
     * @param SurgeryRepositoryInterface $surgery
     * @return void
     */
    public function __construct(SurgeryRepositoryInterface $surgery)
    {
        $this->middleware('auth');
        $this->surgeries = $surgery;

    }

    /**
     * Display a listing of the resource.
     *
     * @return App\Client\Surgery
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\SurgeryPost $request
     * @return App\Repositories\SurgeryRepository
     */
    public function store(SurgeryPost $request)
    {
        return $this->surgeries->save($request);

    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\SurgeryRepository
     */
    public function show($medical_id)
    {
        return $this->surgeries->where($medical_id);

    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\SurgeryPost $request
     * @return App\Repositories\SurgeryRepository
     */
    public function update($id, SurgeryPost $request)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\SurgeryRepository
     */
    public function destroy($id)
    {
        return $this->surgeries->delete($id);

    }
}
