<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'mid_initial',
        'dob', 'street', 'apt_floor','city','state', 'email',
        'zip','work_phone','emergency_phone','cellular',
        'occupation','gender','first_facial','visit_reason',
        'email', 'image', 'file'
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'complete' => 'boolean'
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
     * When setting dob property, mutate back to Unix 
     * time stamp because of database restriction.
     *
     * @param String $dob
     * @return void
     */
    public function setDobAttribute($date)
    {    
        $this->attributes['dob'] = (new Carbon($date) )->toDateString();
    }

    /**
     * When retrieving dob property, mutate from Unix time
     * stamp to this format d/m/y.
     *
     * @param String $dob
     * @return void
     */
    public function getDobAttribute($dob)
    {    
        if( !is_null($dob) ) {
            return (new Carbon())->parse($dob)->format('m/d/Y');
        }
        
    }

    /**
     * When retrieving image name property, mutate from just
     * image name to full url path.
     *
     * @param String $dob
     * @return void
     */
    public function getImageAttribute($image)
    {
        return url('storage/'.$image);
    }

    /**
    * Get the medical record associated with the client.
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function medical()
    {                      
        return $this->hasOne('App\Client\Medical');
        
    }

     /**
    * Get the terms and conditons associated with the client.
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function terms_and_conditions()
    {                      
        return $this->hasOne('App\Client\TermsAndCondition');
        
    }

    /**
    * Get the consultation event for this client model.
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasManey
    */
    public function consultation_events()
    {
        return $this->hasMany('App\Client\Calendar\ConsultationEvent');
    }

    /**
    * Get the consultations for this client model.
    * 
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function consultations()
    {
        return $this->hasMany('App\Client\Consultation');

    }

    /**
     *  Get the invoices for this client model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice()
    {
        return $this->hasMany('App\Client\Invoices\Invoice');
    }

    /**
     * Get the treatments for the client record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_treatments() 
    {
        return $this->hasMany('App\Client\Purchase\Treatment');

    }

    /**
     * Get the discounts for the client record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_discounts() 
    {
        return $this->hasMany('App\Client\Purchase\Discount');

    }

    /**
     * Get the products for the client record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_products()
    {
        return $this->hasMany('App\Client\Purchase\Product');

    }
}
