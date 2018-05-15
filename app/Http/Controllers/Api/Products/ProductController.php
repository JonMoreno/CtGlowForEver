<?php
namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductController extends Controller
{
    /**
     * Product repository.
     *
     * @var ProductRepositoryInterface
     */
    protected $product;

    /**
     * Product model repository layer.
     *
     * @param  ProductRepositoryInterface $product
     * @return void
     */
    public function __construct(ProductRepositoryInterface $products)
    {
        $this->middleware('auth');
        $this->product = $products;
    }

    /**
     * All listings of the resource.
     *
     * @return App\Repository\ProductRepository
     */
    public function index()
    {
        return $this->product->all();
    }

    /**
     * 
     * Store new resource in storage
     * 
     * @param Request $request
     * @return String
     */
    public function store(Request $request) 
    {
        $request->validate([ //validation rules
            'name' => 'required|string|min:2',
            'price' => 'required|numeric|min:1',
            'quantity' => 'nullable|numeric|min:1',
        ]);
        return $this->product->save($request);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     * @param int $id
     * @return ProductRepositoryInterface
     */
    public function update(Request $request , $id)
    {
        $request->validate([ //validation rules
            'name' => 'sometimes|required|min:2',
            'price' => 'sometimes|required|numeric|min:0',
            'quantity' => 'sometimes|required|numeric|min:0',
            'discontinue' => 'sometimes|required|boolean'
        ]);
        return $this->product->update($request, $id);
    }

    /**
     * Detroy specified resource
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->product->delete($id);
    }

    /**
     * Query for specific resource.
     *
     * @param string $name
     * @return ProductRepositoryInterface
     */
    public function search($name) 
    {
        return $this->product->search($name);
    }
}
