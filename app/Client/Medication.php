<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Medication extends Model
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
        'withdrawal_period',
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
     * Mutate unix date to human readable date before
     * value is retrieved.
     *
     * @param string$date
     * @return string
     */
    public function getWithdrawalPeriodAttribute($date)
    {
        if(!is_null($date)){
            return (new Carbon())->parse($date)->format('m/d/Y');
        }
        return $date;
    }
    
    /**
     * Get the medical file that owns the medication.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medical()
    {
        return $this->belongsTo('App\Client\Medical');
    }
}
