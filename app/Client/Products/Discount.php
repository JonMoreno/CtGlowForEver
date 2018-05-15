<?php

namespace App\Client\Products;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Discount extends Model
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
       'name', 'discount_type', 'discount_value'
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
     * Get the purchase_discounts for this discount record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_discounts() 
    {
        return $this->hasMany('App\Client\Purchase\Discount');

    }

}
