<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Consultation extends Model
{
    use SoftDeletes;

    /**
     * Attributes mutated to dates.
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
        'client_id', 'next_appointment' , 'notes', 'time',
    ];

    /**
     * Upon retrieving updated at property, mutate
     * from default to human readable timestamp.
     *
     * @param Float $date
     * @return String
     */
    public function getUpdatedAtAttribute($date)
    {
        return (new Carbon($date))->diffForHumans();
    }

    /**
     * When retrieving created at property, mutate from 
     * Unix time stamp to this format d/m/y.
     *
     * @param String $date
     * @return void
     */
    public function getTimeAttribute($date)
    {    
        if( !is_null($date) ) {
            return (new Carbon())->parse($date)->format('g:iA');
        }
    }

    /**
     * When retrieving created at property, mutate from 
     * Unix time stamp to this format d/m/y.
     *
     * @param String $date
     * @return void
     */
    public function setTimeAttribute($date)
    {    
        if( !is_null($date) ) {
            $this->attributes['time'] = (new Carbon())->parse($date)->format('G:i');
        }else{
            $this->attributes['time'] = NULL;
        }
    }


     /**
     * When retrieving created at property, mutate from 
     * Unix time stamp to this format d/m/y.
     *
     * @param String $date
     * @return void
     */
    public function getCreatedAtAttribute($date)
    {    
        return (new Carbon())->parse($date)->format('m/d/Y');
    }

    /**
     * Mutate back to UNIX timestamp due to some of the 
     * database restrictions when storing timestamps.
     *
     * @param Float $date
     * @return void
     */
    public function setNextAppointmentAttribute($date) 
    {
        if( !is_null($date) ) {
            $this->attributes['next_appointment'] = (new Carbon($date))->toDateString();
        }
    }

    /**
     * When retrieving next appointment property, mutate 
     * from Unix time stamp to this format d/m/y.
     *
     * @param String $date
     * @return void
     */
    public function getNextAppointmentAttribute($date)
    {   
        if( !is_null($date) ) {
            return (new Carbon())->parse($date)->format('m/d/Y');
        }
    }


    /**
     * Get the client that owns this consulation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client() 
    {
        return $this->belongsTo('App\Client\Client');

    }

     /**
     * Get the invoice that is associated with this consultation
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice() 
    {
        return $this->hasOne('App\Client\Invoices\Invoice');

    }
}