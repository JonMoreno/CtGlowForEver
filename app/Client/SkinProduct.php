<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkinProduct extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'medical_id',
        'name',
    ];

    /**
     * When retrieving updated_at property mutate from Unix time 
     * stamp to human readable time by using the Carbon library
     *
     * @param float $timeStamp
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
       $carbon = new Carbon($date); 
       return $carbon->diffForHumans();
    }

    
    /**
     * Get the medical model that owns the skin product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medical()
    {
        return $this->belongsTo('App\Client\Medical');
    }
}
