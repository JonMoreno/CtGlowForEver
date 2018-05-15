<?php

namespace App\Client;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermsAndCondition extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    protected $table = 'terms_and_conditions';

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'client_id', 'name', 'description', 'signature_image'
    ];

    /**
     * When retrieving created_at property, mutate from Unix time
     * stamp to this format d/m/y.
     *
     * @param String $dob
     * @return void
     */
    public function getCreatedAtAttribute($date)
    {
        return (new Carbon())->parse($date)->format('d/m/Y');
    }

    /**
     * When retrieving signature image property, mutate from just
     * image name to full url path.
     *
     * @param String $dob
     * @return void
     */
    public function getSignatureImageAttribute($image)
    {
        return url('storage/'.$image);
    }

    /**
     * Get the client that owns this terms and conditions.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Client\Client');
        
    }
}
