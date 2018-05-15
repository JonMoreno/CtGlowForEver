<?php
namespace App\Repositories;

use App\Client\Products\Product as ProductInventory;
use App\Client\Purchase\Product;
use App\Client\Invoices\Invoice;
use App\Repositories\Contracts\PurchaseProductRepositoryInterface;

class PurchaseProductRepository implements PurchaseProductRepositoryInterface
{
    /**
     * Save new purchase product model.
     *
     * @param App\Http\Requests\PurchaseTreatmentPost
     * @return Boolean
     */
    public function save($data)
    {
        $inventory = ProductInventory::find($data->product_id);
        $qty = $inventory->quantity;
        $inventory->quantity = $qty - 1;
        $inventory->save();
        
        
        $purchase = new Product();
        $purchase->sold_price = $data->sold_price;
        $purchase->client_id = $data->client_id;
        $purchase->invoice_id = $data->invoice_id;
        $purchase->product_id = $data->product_id;
        return collect($purchase->save())->toJson();

    }

    /**
     * Return product models with specified condition.
     *
     * @param String $ref
     * @return App\Purchase\Product
     */
    public function byInvoice($reference)
    {
        $invoice = Invoice::find($reference);

        foreach($invoice->purchase_products as $purchase_product){
            $purchase_product->product;
        }

        return $invoice->purchase_products;
    }
}