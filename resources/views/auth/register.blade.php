@extends('layouts.app')

@section('login')
<br/>
<!-- CONTAINER -->
<div class="container">
	<!-- ROW -->
    <div class="row align-items-end justify-content-center d-flex align-items-center full-height">
    		<!-- COL -->
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        		<!-- Card -->
            <div class="card">
				<!-- Card-Body -->
                <div class="card-body">
                <!-- Card-Title -->
                <h4 class="card-title"> 
                    <i id="user-md"class="fa fa-user-md text-light-primary fa-2x" aria-hidden="true"></i>
                    Register
                </h4>
                <!-- Card-Sub-Title -->
                <h6 class="card-subtitle mb-2 text-muted"> Please, provide your details </h6>
                		<!-- Register-Form -->
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
						<!-- Name-Input -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} row">
                        		<!-- Label -->
                            <label for="name" class="col-12  control-label">Name:</label>

                            <div class="col-12 ">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<!-- Email-Input -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                        		<!-- Label -->
                            <label for="email" class="col-12 control-label">Email Address:</label>

                            <div class="col-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<!-- Password-Input-->
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                        		<!-- Label -->
                            <label for="password" class="col-12 control-label">Password:</label>

                            <div class="col-12">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						<!-- Confirm-Password -->
                        <div class="form-group row">
                            <label for="password-confirm" class="col-12 control-label">Confirm Password</label>

                            <div class="col-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                            </div>
                        </div>
						<!-- Register-Button -->
                        <div class="form-group row pt-2">
                            <div class="col-8 ml-auto">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                        
                    </form><!--../Register-Form -->
                </div><!--../Card-Body -->
            </div><!--../Card-->
        </div><!--../COL-->
    </div><!--../ROW -->
</div><!--../CONTAINER -->

@endsection
