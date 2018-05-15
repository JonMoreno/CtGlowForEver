<?php

namespace App\Client\Invoices;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoice extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'next_appointment' , 'price'
    ];


    /**
     * Get the consultation that owns this invoice.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consultation() 
    {
        return $this->belongsTo('App\Client\Consultation');

    }
    

    /**
     * Get the client that owns this invoice.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client() 
    {
        return $this->belongsTo('App\Client\Client');

    }

    /**
     * Get the purchase_treatments for the invoice record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_treatments() 
    {
        return $this->hasMany('App\Client\Purchase\Treatment');

    }

    /**
     * Get the purchase_discounts for the invoice record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_discounts() 
    {
        return $this->hasMany('App\Client\Purchase\Discount');

    }

    /**
     * Get the purchase_products for the invoice record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_products()
    {
        return $this->hasMany('App\Client\Purchase\Product');

    }
}
