

@extends('layouts.app')


@section('content')
<!-- CLIENT ROw -->
	<div class="row">

		<div class="col-12 col-lg-12 mx-auto">
			<!-- Paginantion -->
			<ul class="pagination mb-3 mt-3">
				<li class="page-item disabled">
					<a class="page-link font-weight-bold text-primary" href="#">
						<i class="fa fa-info-circle fa-lg text-info" aria-hidden="true"></i> 
						BASIC INFORMATION
						<br/>
						<span class="font-weight-normal text-muted">
							These are your client's personal details. Please, keep them up to date.
					</a>
				</li>            	
			</ul><!-- ../Pagination --> 
		</div>

	<!-- CLIENT COL -->
        <div class="col-12 col-md-12 col-lg-12 col-xl-11 mx-auto">
		<!-- CLIENT REVISE FORM -->
			<client-revise record="{{$client}}"></client-revise>	

		</div>
	<!-- ../CLIENT COL -->
	</div>	
<!-- ../CLIENT ROW -->	
@endsection