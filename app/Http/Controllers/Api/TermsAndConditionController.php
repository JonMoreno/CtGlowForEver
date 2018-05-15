<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Client\TermsAndCondition;
use App\Http\Controllers\Controller;


class TermsAndConditionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retrieve all models for this resource.
     *
     * @return App\Client/TermsAndCondition
     */
    public function index()
    {
        return TermsAndCondition::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_uri = $request->input('signature');
        $encoded_image = explode(",", $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);
        Storage::put('public/'.$request->input('signature_image'), $decoded_image);

        $terms = new TermsAndCondition();
        $terms->name = $request->input('name');
        $terms->client_id = $request->input('client_id');
        $terms->description = $request->input('description');
        $terms->signature_image = $request->input('signature_image');
        $terms->save();
    }
}
