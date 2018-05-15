<?php
namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\DiscountRepositoryInterface;
use App\Repositories\Contracts\TreatmentRepositoryInterface;

class ServiceController extends Controller
{
    /**
     * Product repository.
     *
     * @var ProductRepositoryInterface
     */
    protected $product;

    /**
     * Discount repository.
     *
     * @var DiscountRepositoryInterface
     */
    protected $discount;

    /**
     * Treatmen repository.
     *
     * @var TreatmentRepositoryInterface
     */
    protected $treatment;

    /**
     * Product,Discount,Treament model repository layer.
     *
     * @param  ProductRepositoryInterface $product
     * @return void
     */
    public function __construct( ProductRepositoryInterface $products,
                                 DiscountRepositoryInterface $discounts,
                                 TreatmentRepositoryInterface $treatments)
    {
        $this->middleware('auth');
        $this->product = $products;
        $this->discount = $discounts;
        $this->treatment = $treatments;
    }

    /**
     * Display all product resources
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        $products = $this->product->all();
        return view('services.show_products', compact('products'));
        
    }
    /**
     * Display all discount resources
     *
     * @return \Illuminate\Http\Response
     */
    public function discounts()
    {
        $discounts = $this->discount->all();
        return view('services.show_discounts', compact('discounts'));
    }

    /**
     * Display all treatment resources
     *
     * @return \Illuminate\Http\Response
     */
    public function treatments()
    {
        $treatments = $this->treatment->all();
        return view('services.show_treatments', compact('treatments'));
    }

}
