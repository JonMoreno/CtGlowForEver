<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Requests\IllnessPost;  
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IllnessRepositoryInterface;


class IllnessController extends Controller
{
    /**
     * Illness repository.
     *
     * @var IllnessRepositoryInterface
     */
    protected $illness;
    
    /**
     * Illness model repository layer.
     *
     * @param IllnessRepositoryInterface $illness
     * @return void
     */
    public function __construct(IllnessRepositoryInterface $illness)
    {
        $this->middleware('auth');
        $this->illness = $illness;

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Client\Illness
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\IllnessPost $request
     * @return App\Repositories\IllnessRepository
     */
    public function store(IllnessPost $request)
    {
        return $this->illness->save($request);
        
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\IllnessRepository
     */
    public function show($medical_id)
    {
        return $this->illness->where($medical_id);

    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\IllnessPost $request
     * @return App\Repositories\IllnessRepository
     */
    public function update($id, IllnessPost $request)
    {
        //
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\IllnessRepository
     */
    public function destroy($id)
    {
        return $this->illness->delete($id);

    } 
}
