<?php
namespace App\Repositories;

use App\Client\Client;
use App\Client\Consultation;
use App\Repositories\Contracts\CalendarRepositoryInterface;

class CalendarRepository implements CalendarRepositoryInterface
{
    
    public function consultationEvents()
    {
        $consultations = Consultation::with('client')->get();
        return $consultations;
    }

}