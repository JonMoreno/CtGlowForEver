<?php
namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkinProductPost;
use App\Repositories\Contracts\SkinProductRepositoryInterface;

class SkinProductController extends Controller
{
    /**
     * SkinProduct repository.
     *
     * @var SkinProductRepositoryInterface
     */
    protected $skinProducts;
    
    /**
     * SkinProduct model repository layer.
     *
     * @param SkinProductRepositoryInterface $skinProduct
     * @return void
     */
    public function __construct(SkinProductRepositoryInterface $skinProduct)
    {
        $this->middleware('auth');
        $this->skinProducts = $skinProduct; 
       
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return App\Client\SkinProduct
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\SkinProductPost $request
     * @return App\Repositories\SkinProductRepository
     */
    public function store(SkinProductPost $request) 
    {
        return $this->skinProducts->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param String $id
     * @return App\Repositories\SkinProductRepository
     */
    public function show($medical_id) // !!! TESTED !!!
    {
        return $this->skinProducts->where($medical_id);

    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  int  $id
     * @param  App\Http\Requests\SkinProductPost $request
     * @return App\Repositories\SkinProductRepository
     */
    public function update($id, SkinProductPost $request)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return App\Repositories\SkinProductRepository
     */
    public function destroy($id) 
    {
        $this->skinProducts->delete($id);

    }
}


