<?php

namespace App\Http\Controllers\Api\Purchases;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseProductPost;
use App\Repositories\Contracts\PurchaseProductRepositoryInterface;

class ProductController extends Controller
{
    /**
     * Purchased Products repository.
     *
     * @var PurchaseProductRepositoryInterface
     */
    protected $purchase;

    /**
     * Inject purchased Products repository.
     *
     * @param PurchaseProductRepositoryInterface $purchaseProducts
     */
    public function __construct(PurchaseProductRepositoryInterface $purchases)
    {
        $this->middleware('auth');
        $this->purchase = $purchases;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PurchaseProductPost $request
     * @return Boolean
     */
    public function store(PurchaseProductPost $request)
    {
        return $this->purchase->save($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  String $id
     * @return  PurchaseProductRepositoryInterface
     */
    public function show($id)
    {
        return $this->purchase->byInvoice($id);
    }
}
