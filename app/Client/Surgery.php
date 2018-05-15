<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surgery extends Model
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
        'location',
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
     * Get the medical file that owns the stress level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medical()
    {
        return $this->belongsTo('App\Client\Medical');
    }
    
}
