
<!-- EXTENDING LAYOUT -->
@extends('layouts.app')


@section('custom-style')

@endsection


@section('content')
	
	<medical-card-group  records="{{$medical}}">
        <template slot-scope="{parent}">
        
            	<medical-card
            		:info ="parent"
            	></medical-card>

				<stress-level-card 
					:info="parent"
				></stress-level-card>
            	
            	<skin-product-card 
            		:info="parent"
            	></skin-product-card>
                	
            	<medication-card 
            		:info ="parent" 
            	></medication-card>
            	
            	<allergie-card
            		:info ="parent"
            	></allergie-card>
            	
            	<surgery-card
            		:info ="parent"
            	></surgery-card>
            	
            	<illness-card
            		:info ="parent"
            	></illness-card>
            	
        	
        </template>
     </medical-card-group>

@endsection


