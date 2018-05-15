<!-- EXTENDING LAYOUT -->
@extends('layouts.app')


<!-- INSERTING SECTION TO LAYOUT -->
@section('content')
<!-- CONTAINER COL -->
<div class="col-8 col-sm-9 col-md-9 col-lg-9 col-xl-10">
<div class="block-75"></div>



		<!-- FORM PAGINATION -->
		<ul class="pagination mb-0">
        		<li class="page-item disabled">
        			<a class="page-link font-weight-bold text-primary" href="#"> 
        				Information <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
        			</a>
        		</li>
        		<li class="page-item active">
        			<a class="page-link " href="{{ url('/clients/create') }}">Basic</a>
        		</li>
        		<li class="page-item ">
        			<a class="page-link" href="{{ url('/medicals/create') }}">Medical</a>
        		</li>
         </ul><!-- ../FORM PAGINATION -->
         
         <br/>
		<!-- CARD -->
		<div class="card ml-2 mr-2">
		<div class="card-header text-primary">
        	
		</div>

			<client-form> </client-form>

		<br/>
		<br/>
		<br/>
		<br/>
		<br/>
		<br/>

			
		</div><!-- ../CARD -->



</div>
@endsection
<!-- ../INSERTING SECTION TO LAYOUT -->


