<?php
namespace App\Repositories;

use App\Client\Purchase\Discount;
use App\Client\Invoices\Invoice;
use App\Repositories\Contracts\PurchaseDiscountRepositoryInterface;

class PurchaseDiscountRepository implements PurchaseDiscountRepositoryInterface
{
    
    /**
     * Save new purchase treatment model.
     *
     * @param App\Http\Requests\PurchaseTreatmentPost
     * @return Boolean
     */
    public function save($data)
    {
        $purchase = new Discount();
        $values = $data->all();

        foreach ($values as $prop => $value) {
            $purchase->{$prop} = $value;
        }
        return collect($purchase->save())->toJson();
    }

    public function byInvoice($reference)
    {
        $invoice = Invoice::find($reference);

        foreach($invoice->purchase_discounts as $purchase_discount){
            $purchase_discount->discount;
        }

        return $invoice->purchase_discounts;
    }

}