<?php

namespace App\Http\Controllers\Api\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\StressLevelRepositoryInterface;


class StressLevelController extends Controller
{
    /**
     * StressLevel repository.
     *
     * @var StressLevelRepositoryInterface 
     */
    protected $stressLevel;
    
    /**
     * StressLevel model repository layer.
     * 
     * @param StressLevelRepositoryInterface $stressLevel
     */
    public function __construct(StressLevelRepositoryInterface $stressLevel)
    {
        $this->middleware('auth');
        $this->stressLevel = $stressLevel;
        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Client\StressLevel
     */
    public function index()
    {
        //

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return App\Repositories\StressLevelRepository
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'stress_level' => 'required|numeric|between:0,10',
        ]);

        return $this->stressLevel->save($request);

    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\StressLevelRepository
     */
    public function show($id)
    {
        return $this->stressLevel->where($id);

    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\StressLevelPost $request
     * @return App\Repositories\StressLevelRepository
     */
    public function update($id, Request $request)
    {   
        $validation = $request->validate([
            'stress_level' => 'required|numeric|between:0,10',
        ]);

        return $this->stressLevel->update($id, $request);
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\StressLevelRepository
     */
    public function destroy($id)
    {
        return $this->stressLevel->delete($id);
        
    }
    

}
