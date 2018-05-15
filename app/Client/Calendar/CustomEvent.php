<?php

namespace App\Client\Calendar;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomEvent extends Model
{
    use SoftDeletes;

    /**
     * Attributes mutated to cabon instance dates.
     *
     * @var array
     */
    protected $date = [ 'deleted_at', 'date', 'time'];

    /**
     * Attributes that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [ 'title', 'time', 'date', 'desciption' ];



}
