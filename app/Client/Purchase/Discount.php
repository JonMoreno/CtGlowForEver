<?php

namespace App\Client\Purchase;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Discount extends Model
{
    use SoftDeletes;
    
     /**
     * Attributes mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_discounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discount_id', 'client_id', 
        'invoice_id', 'service', 
        'service_id', 'discount_price'
    ];

    /**
     * Get the client that owns the purchase discount model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Client\Client');

    }

    /**
     * Get the invoice file that owns the purchase discount model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo('App\Client\Invoices\Invoice');

    }

    /**
     * Get the discount model that owns the purchase discount model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo('App\Client\Products\Discount');

    }
}
