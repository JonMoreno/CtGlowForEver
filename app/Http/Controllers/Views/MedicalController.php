<?php

namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;


class MedicalController extends Controller
{
    /**
     * Medical repository.
     *
     * @var MedicalRepositoryInterface 
     */
    protected $medicalRecord;
    
    /**
     * Medical model repository layer.
     * 
     * @param MedicalRepositoryInterface $medical
     */
    public function __construct(MedicalRecordRepositoryInterface $medicalRecord)
    {
        $this->medicalRecord = $medicalRecord;
        $this->middleware('auth');
       
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Responses\Views\Medical\create_medical
     */    
    public function create()
    {
        return view('medical.create_medical');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Responses\Views\Medical\show_medical
     */
    public function show($id)
    {       
        $medical = $this->medicalRecord->find($id);
        return view('medical.show_medical', compact('medical'));
        
    }  
}
