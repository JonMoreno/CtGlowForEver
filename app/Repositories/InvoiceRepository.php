<?php
namespace App\Repositories;

use App\Client\Invoices\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * Save new invoice model for the client.
     *
     * @param App\Http\Controllers\Api\InvoiceController $data
     * @return App\Client\Invoices\Invoice
     */
    public function save($data)
    {
        $invoice = new Invoice();
        $invoice->client_id = $data->client_id;
        $invoice->consultation_id = $data->consultation_id;
        $invoice->total_price = $data->total_price;
        $invoice->save();

        return $invoice->id;
    }

    public function whereConsultation($id) 
    {
        return Invoice::where('consultation_id', $id)->get();

    }

}