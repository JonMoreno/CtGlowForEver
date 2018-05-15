<?php

namespace App\Http\Controllers\Api\Purchases;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseDiscountPost;
use App\Repositories\Contracts\PurchaseDiscountRepositoryInterface;

class DiscountController extends Controller
{
    /**
     * Purchased Discounts repository.
     *
     * @var PurchaseDiscountRepositoryInterface
     */
    protected $purchase;

    /**
     * Inject purchased Discounts repository.
     *
     * @param PurchaseDiscountRepositoryInterface $purchaseDiscounts
     */
    public function __construct(PurchaseDiscountRepositoryInterface $purchases) 
    {
        $this->middleware('auth');
        $this->purchase = $purchases;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PurchaseDiscountPost $request
     * @return Boolean
     */
    public function store(PurchaseDiscountPost $request)
    {
        return $this->purchase->save($request);

    }

    /**
     * Retrieve all associated resources.
     *
     * @param  String $id
     * @return PurchaseTreatmentRepositoryInterface 
     */
    public function show($id)
    {
        return $this->purchase->byInvoice($id);
    }
}
