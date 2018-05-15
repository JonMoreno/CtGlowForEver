@extends('layouts.app')

@section('login')

    <!-- CONTAINER -->
    <div class="container">
        <!-- ROW -->
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 d-flex align-items-center justify-content-center full-height ">

                <animate-bounce :view="false">
                    <!-- Card -->
                    <div class="card border-light-secondary mx-auto">

                    <!-- Card-Body -->
                        <div class="card-body">
                        
                        <!-- Card-Title -->
                        <h4 class="card-title">
                            <i id="user-md"class="fa fa-user-md text-light-primary fa-2x" aria-hidden="true"></i>
                            Log In
                        </h4>
                        <!-- Card-Sub-Title -->
                            <h6 class="card-subtitle mb-2 text-muted">Please, provide your credentials.</h6>
                        <!-- Log-In-Form -->
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <!-- EMAI INPUT -->
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                                        <!-- Label -->
                                    <label for="email" class="col-12 control-label">Email Address:</label>
                                    <div class="col-12 ">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- PASSWORD INPUT -->
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                                    <!-- Label -->
                                    <label for="password" class="col-12 control-label">Password:</label>
        
                                    <div class="col-12">
                                        <input id="password" type="password" class="form-control" name="password" required>
        
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- REMEMBER-CHECKBOX-INPUT -->
                                    <!--
                                    <div class="form-group row">
                                        <div class="col-8 ml-auto">
                                            <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" 
                                                        type="checkbox" 
                                                        name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        Remember Me
                                            </label>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                    
                                <!-- LOG-IN-BUTTON -->
                                <div class="form-group row">
                                    <div class="col-12 text-center mt-3">
                                        <button type="submit" class="btn btn-outline-primary" style="margin-left: 16px;">
                                            <i class="fa fa-sign-in fa-lg" aria-hidden="true"></i>Login
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="form-group row pt-2">
                                        <div class="col-9 ml-auto">
                                        <!-- FORGOT-PASSWORD -->
                                        <a class="btn btn-link " href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div> --}}
                            </form>
                        </div><!--../Card-Body-->
                    </div><!--../Card -->
                </animate-bounce>
            </div><!--../COL -->
        </div><!--../ROW -->
        
    </div><!--../CONTAINER -->
@endsection
