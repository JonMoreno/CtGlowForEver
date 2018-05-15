<?php

namespace App\Client\Calendar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class ConsultationEvent extends Model
{
    use SoftDeletes;

    /**
     * Attributes mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'date' , 'time', 'description',
    ];

    /**
     * When retrieving updated_at property, mutate from Unix time
     * stamp to human readable time by using the Carbon library
     *
     * @param Float $timeStamp
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return (new Carbon($date))->diffForHumans();
    }

    /**
     * Get the client that owns this consulation event.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client() 
    {
        return $this->belongsTo('App\Client\Client');

    }

    /**
     * When retrieving date property, mutate 
     * from Unix time stamp to this format 'Y-m-d'
     *
     * @param String $date
     * @return void
     */
    public function getDateAttribute($date)
    {   
        if( !is_null($date) ) {
            return (new Carbon($date))->format('Y-m-d');
        }
    }
}
