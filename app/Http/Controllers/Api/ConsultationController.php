<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationPost;
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
     * @param  String $id
     * @return App\Client\Consultation
     */
    public function show($id)
    {   
        return $this->consultation->findAll($id);
    }

    /**
     * Undocumented function
     *
     * @param Sring $id
     * @return App\Client\Consultation
     */
    public function latest($id) 
    {
        return $this->consultation->clientsLatest($id);
    }

    /**
     * After validation store a newly created resource in storage.
     *
     * @param ConsultationPost $request
     * @return String
     */
    public function store(ConsultationPost $request)
    {
        return $this->consultation->save($request);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param String $id
     * @param ConsultationPost $request
     * @return String
     */
    public function update($id, ConsultationPost $request)
    {        
        return $this->consultation->update($id , $request);
    }
}
