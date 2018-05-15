<?php

namespace App\Http\Controllers\Api\Purchases; 

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseTreatmentPost;
use App\Repositories\Contracts\PurchaseTreatmentRepositoryInterface;

class TreatmentController extends Controller
{
    /**
     * Purchased treatments repository.
     *
     * @var PurchaseTreatmentRepositoryInterface
     */
    protected $purchases;

    /**
     * Inject purchased treatments repository.
     *
     * @param PurchaseTreatmentRepositoryInterface $purchaseTreatments
     */
    public function __construct(PurchaseTreatmentRepositoryInterface $purchases) 
    {
        $this->middleware('auth');
        $this->purchases = $purchases;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PurchaseTreatmentPost $request
     * @return Boolean
     */
    public function store(PurchaseTreatmentPost $request)
    {
        return $this->purchases->save($request);

    }

    /**
     * Retrieve all associated resources.
     *
     * @param  String $id
     * @return PurchaseTreatmentRepositoryInterface 
     */
    public function show($id)
    {
        return $this->purchases->byInvoice($id);
    }
}
