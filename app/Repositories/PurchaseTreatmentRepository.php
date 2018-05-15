<?php
namespace App\Repositories;

use App\Client\Invoices\Invoice;
use App\Client\Purchase\Treatment;
use App\Repositories\Contracts\PurchaseTreatmentRepositoryInterface;

class PurchaseTreatmentRepository implements PurchaseTreatmentRepositoryInterface
{
    /**
     * Save new purchase treatment model.
     *
     * @param App\Http\Requests\PurchaseTreatmentPost
     * @return Boolean
     */
    public function save($data)
    {
        $purchase = new Treatment();
        $purchase->sold_price = $data->sold_price;
        $purchase->client_id = $data->client_id;
        $purchase->invoice_id = $data->invoice_id;
        $purchase->treatment_id = $data->treatment_id;
        return collect($purchase->save())->toJson();

    }

    public function byInvoice($reference)
    {
        $invoice = Invoice::find($reference);

        foreach($invoice->purchase_treatments as $purchase_treatment){
            $purchase_treatment->treatment;
        }

        return $invoice->purchase_treatments;
    }

}