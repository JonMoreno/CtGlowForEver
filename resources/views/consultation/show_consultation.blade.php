@extends('layouts.app')


@section('content')
<!-- ROW -->
	<div class="row">
	<!-- COL -->
        <div class="col-12 col-md-12 col-lg-12 col-xl-12 mx-auto">
		<!-- Paginantion -->
			<ul class="pagination mb-0 mt-3">
				<li class="page-item disabled">
					<a class="page-link font-weight-bold text-primary" href="#">
						<i class="fa fa-info-circle fa-lg text-info" aria-hidden="true"></i> 
						CONSULTATIONS<br/>
						<span class="font-weight-normal text-muted">
							These are all your client's consultations.
						</span>
					</a>
				</li>            	
			</ul><!-- ../Pagination -->
			<!-- CLIENT CONSULTATION MODAL-BTN -->
			<div class="mb-3 mt-4 text-center">
				<button 
					@click="onConsultation()"

					type="button"
					data-toggle="modal" 
					data-target="#exampleModalCenter"
					class="btn btn-primary px-5 ls-1"  
				>
					<i class="fa fa-cart-plus fa-lg" aria-hidden="true"></i> Consultation 
				</button>
			</div>

			<!-- CLIENT CONSULTATION MODAL -->
				<consultation-modal class="mb-2"></consultation-modal>

			<!-- Consultations -->
				<consultation-list info="{{$consultations}}"></consultation-list>
		</div>
	<!-- ../COL -->
	</div>	
<!-- ../ROW -->	
@endsection