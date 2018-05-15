<?php
namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\TreatmentRepositoryInterface;


class TreatmentController extends Controller
{
    /**
     * Treatments repository.
     *
     * @var TreatmentRepositoryInterface;
     */
    protected $treatment;

    /**
     * Inject treatments repository.
     *
     * @param TreatmentRepositoryInterface $treatments
     */
    public function __construct(TreatmentRepositoryInterface $treatments)
    {
        $this->middleware('auth');
        $this->treatment = $treatments;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->treatment->all();
    }

    /**
     * Store newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'price' => 'required|numeric|min:1',
        ]);
        return $this->treatment->save($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|min:2',
            'price' => 'sometimes|required|numeric|min:0',
        ]);
        return $this->treatment->update($request, $id);
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param String $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->treatment->delete($id);
    }

    /**
     * Query for specific resource.
     *
     * @param string $name
     * @return ProductRepositoryInterface
     */
    public function search($name) 
    {
        return $this->treatment->search($name);
    }
}
