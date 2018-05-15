<?php
namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\DiscountRepositoryInterface;

class DiscountController extends Controller
{
    /**
     * Products repository.
     *
     * @var DiscountRepositoryInterface
     */
    protected $discount;

    /**
     * Inject products repository.
     *
     * @param DiscountRepositoryInterface $discounts
     */
    public function __construct(DiscountRepositoryInterface $discounts) 
    {
        $this->middleware('auth');
        $this->discount = $discounts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->discount->all();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'discount_type' => 'required|string|min:8',
            'discount_value' => 'required|numeric'
        ]);
        return $this->discount->save($request);
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
        $request->validate([
            'name' => 'sometimes|required|string|min:2',
            'discount_type' => 'sometimes|required|string|min:8',
            'discount_value' => 'sometimes|required|numeric'
        ]);
        return $this->discount->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->discount->delete($id);
    }

    /**
     * Query for specific resource.
     *
     * @param string $name
     * @return ProductRepositoryInterface
     */
    public function search($name) 
    {
        return $this->discount->search($name);
    }
}
