
@extends('layouts.app')


@section('content')

<!-- CLIENTS ROW -->
    <div class="row">
	<!-- CLIENTS COL -->
        <div class="col-12 col-sm-10 col-md-11 col-lg-9 col-xl-8 mx-auto">

       			<!-- CLIENTS CARD -->
            	<div class="card bg-light mt-3">
            		<!-- CLIENTS CARD-HEADER -->
					<div class="card-header text-center text-muted py-3 h4 ls-1">
						<i class="fa fa-list-alt fa-lg " aria-hidden="true"></i> 
						All Of Your Clients
					</div>
                	<!-- CLIENTS CARD-BODY -->   
                	<div class="card-body">
					<!-- CLIENTS CARD-SUBTITLE --> 
						<div class="card-subtitle"> 
							<i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
							Please, select desired client.
						</div>
						<!-- NEW CLIENT DROP-DOWN FORM --> 
						<client-dropdown> </client-dropdown>
						<!-- CLIENT CONSULTATION MODA -->
						<consultation-modal></consultation-modal>
						<!-- CLIENT LIST -->
						<client-list> </client-list>
        			    			        		   
                	</div><!--../MAIN-CARD-BODY -->
				</div><!--../MAIN-CARD -->
        </div>  
    </div>

@endsection

