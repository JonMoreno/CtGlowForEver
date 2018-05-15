<?php

namespace  App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medical extends Model
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
        'dermatologist', 'pregnant',
        'glasses', 'smoke',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dermatologist' => 'boolean',
        'pregnant' => 'boolean',
        'glasses' => 'boolean',
        'smoke' => 'boolean',
        'complete' => 'boolean'
    ];
    
    /**
     * When retrieving updated_at property mutate from Unix time 
     * stamp to human readable time by using the Carbon library 
     * 
     * @param float $timeStamp
     * @return string
     */
    public function getUpdatedAtAttribute($timeStamp)
    {
        $time = new Carbon($timeStamp);
        return $time->diffForHumans();
    }
    
    /**
     * Get the allergies for the medical record.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allergies()
    {
        return $this->hasMany('App\Client\Allergie');
    }
    
    /**
     * Get the client that owns this medical file
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Client\Client');
        
    }
    
    /**
     *  Get the illnesses for the medical record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function illnesses()
    {
        return $this->hasMany('App\Client\Illness');
    }
    
    /**
     *  Get the medications for the medical record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medications()
    {
        return $this->hasMany('App\Client\Medication');
    }
    
    /**
     *  Get the skin products for the medical record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skinProducts()
    {
        return $this->hasMany('App\Client\SkinProduct');
    }
    
   /**
    *  Get the stress levels for the medical record.
    *  
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function stressLevels()
    {
        return $this->hasMany('App\Client\StressLevel');
        
    }
    
    /**
     *  Get the surgeries for the medical record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */ 
    public function surgeries()
    {
        return $this->hasMany('App\Client\Surgery');
        
    }
    
  
    
}
