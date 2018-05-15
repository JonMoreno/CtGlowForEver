<?php

namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ConsultationRepositoryInterface;


class ConsultationController extends Controller
{
    /**
     * Consultations repository.
     *
     * @var ConsultationRepositoryInterface
     */
    protected $consultation;

    /**
     * Inject consultations repository.
     *
     * @param ConsultationRepositoryInterface $consultations
     */
    public function __construct(ConsultationRepositoryInterface $consultations) 
    {
        $this->middleware('auth');
        $this->consultation = $consultations;
    }

    /**
     * Retrieve all consultation models belonging to 
     * the the clien
     *
     * @param  int  $id
     * @return Resources\Views\Consultation\show_client_consultation
     */
    public function show($id)
    {   
        $consultations = $this->consultation->findAll($id);

        return view('consultation.show_consultation', compact('consultations'));

    }
}
