
@extends('layouts.app')

@section('custom-style')
	{{-- <link href="{{ asset('css/calendar.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')

<!-- Card -->
	<div class="row">
		<div class="col-12 mx-auto px-1 px-sm-2 px-md-3 px-lg-3">
			<div class="px-lg-3 mx-lg-2">
				<welcome-widget 
					user="{{Auth::user()->name}}"
				></welcome-widget>
			</div>
		</div>
	</div>

		<div class="row">
			<div class="col-12 mx-auto px-1 px-sm-2 px-md-3 px-lg-5">
				<div class="px-lg-3 mx-lg-3">
				<reminder-widget></reminder-widget>
				</div>
			</div>
		</div>
			

@endsection
