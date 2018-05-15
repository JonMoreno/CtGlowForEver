<?php

namespace App\Client\Products;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $date = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'quantity', 'discontinue',
    ]; 

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discontinue' => 'boolean',
    ];

    /**
     * Mutate property update_at from Unix time stamp to
     * human readable time by using the Carbon library 
     * 
     * @param float $date
     * @return string
     */
    public function getUpdatedAtAttribute($timeStamp)
    {
        $time = new Carbon($timeStamp);
        return $time->diffForHumans();
    }

    /**
     * Get the purchase_products for this product record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_products()
    {
        return $this->hasMany('App\Client\Purchase\Product');

    }
}
