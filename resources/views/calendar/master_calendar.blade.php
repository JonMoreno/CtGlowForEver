@extends('layouts.app')

@section('custom-style')
	<link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- Card -->
	<div  
		class="card card-body my-2 mx-2"
		:class="{'pointer-event-none' : isActivePointer}">

		<full-calendar></full-calendar>
			
	</div>

@endsection