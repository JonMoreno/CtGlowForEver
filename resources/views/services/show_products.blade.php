@extends('layouts.app')

@section('content')

    <!-- Paginantion -->
	    <ul class="pagination mb-0">
    
        	    <li class="page-item disabled pl-3">
        	        <a class="page-link font-weight-bold text-primary" href="#">
						<i class="fa fa-info-circle fa-lg text-info" aria-hidden="true"></i> 
        	           	PRODUCTS INVENTORY CATALOG
        	        </a>
             </li>            	
        </ul>

	<!-- Info help -->
        <p class="mt-3 mb-0 pl-5 text-muted">
	    	Select a product you wish to work with in order to make changes...
		</p>
		
	    <hr class="my-0"/>

	<!-- Products List-->
		<product-list :records="{{$products}}"> </product-list>

@endsection