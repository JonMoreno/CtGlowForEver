@extends('layouts.app')


@section('content')
<!-- ROW -->
	<div class="row">
	<!-- COL -->
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto">

		<!-- Paginantion -->
			<ul class="pagination my-3">
				<li class="page-item disabled border-light-secondary">
					<a class="page-link font-weight-bold text-primary" href="#">
						<i class="fa fa-info-circle fa-lg text-info" aria-hidden="true"></i>
						SCHEDULED APPTS <br/>
						<span class="font-weight-normal text-muted">
							 
							To schedule an appointment go back to the master calendar
						</span>
					</a>
				</li>            	
			</ul><!-- ../Pagination -->

		<!-- Client Appointment List -->
			<appt-list records="{{ $response }}"> </appt-list>

		</div>
	<!-- ../COL -->
	</div>	
<!-- ../ROW -->	
@endsection