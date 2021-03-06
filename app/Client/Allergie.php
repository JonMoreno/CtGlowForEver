<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Allergie extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
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
     * Get the medical record that owns the allergy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medical()
    {
        return $this->belongsTo('App\Client\Medical');
    }
}
