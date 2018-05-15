@extends('layouts.app')

@section('content')

    <!-- Paginantion -->
	    <ul class="pagination mb-0">
    
        	    <li class="page-item disabled pl-3">
        	        <a class="page-link font-weight-bold text-primary" href="#">
						<i class="fa fa-info-circle fa-lg text-info" aria-hidden="true"></i> 
        	           	TREATMENTS INVENTORY CATALOG
        	        </a>
             </li>            	
        </ul>

	<!-- Info help -->
        <p class="mt-3 mb-0 pl-5 text-muted">
	    	Select a treatment you wish to work with in order to make changes...
		</p>
		
	    <hr class="my-0"/>

	<!-- Treatments List-->
		<treatment-list :records="{{$treatments}}"> </treatment-list>

@endsection