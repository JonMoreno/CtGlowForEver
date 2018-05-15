<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InvoicePost;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\InvoiceRepositoryInterface;

class InvoiceController extends Controller
{
    /**
     * Invoice repository.
     *
     * @var InvoiceRepositoryInterface
     */
    protected $invoice;

    /**
     * Inject Invoice repository.
     *
     * @param InvoiceRepositoryInterface $invoices
     */
    public function __construct(InvoiceRepositoryInterface $invoices)
    {
        $this->middleware('auth');
        $this->invoice = $invoices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\InvoicePost $request
     * @return App\Client\Invoices\Invoice
     */
    public function store(InvoicePost $request)
    {
        return $this->invoice->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->invoice->whereConsultation($id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
