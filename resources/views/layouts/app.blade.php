<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <title>{{ config('app.name', 'GlowForEver') }}</title>
        
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{  secure_asset('css/transitions.css') }}" rel="stylesheet">
        
        <!-- CUSTOM STYLE FILES -->
        @yield('custom-style')

    </head>

<body class="bg-light-secondary" id="html-ready" style="display: none">

<!-- APP -->
<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light nav-bb-x-light fixed-top">
            <a class="navbar-brand text-primary" href="{{ secure_url('/') }}">
                {{ config('app.name', 'GlowForEver') }}/<span class="text-muted fs-75">Admin v1.0<small class="gfe-text-red">BETA</small></span>
            </a>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ secure_url('/login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ secure_url('/register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary text-right" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <i class="fa fa-user-md fa-lg" aria-hidden="true"></i> 
                        </a>
                        <div class="dropdown-menu dropdown-menu-right py-1" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item text-right pr-3" href="{{ secure_url('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                Logout <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>
                            </a>
                            <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
                <div class="d-block d-md-none">
                    <aside-menu></aside-menu>
                </div>
                @endguest
            </div>
        </nav>

    <!-- CONTENT  -->	
        @yield('login')
    <!-- ../CONTENT  -->
	   
	   
    @auth
	<!-- CONTAINER-FLUID -->
	   <div class="container-fluid" >
        <!-- ROW -->
	   		<div class="row">
            <!-- COL -->
	   			<div class="col-4 col-sm-3 col-md-3 col-lg-3 col-xl-2 borderr-light-secondary mh-100 d-none d-md-block">
                <!-- ROW -->
	   			    <div class="row borderr-light-secondary">
                    <!-- COL -->
                        <div class="col-4 col-sm-3 col-md-3 col-lg-3 col-xl-2 borderr-light-secondary bg-light aside-fixed pr-1 pl-0">
                            
                            <aside-menu></aside-menu>

                        </div>
                    <!-- ../COL -->
                    </div>
                <!-- ../ROW -->
                </div>
            <!-- ../COL -->

    <!-- MAIN CONTENT WRAPPER -->
                <!-- COL -->
                <div class="col-12 col-md-9 col-lg-9 col-xl-10 has-min-height bg-light-secondary mx-auto">
                    <div class="block-70"></div>

                <!-- Client Search Bar & Results -->
                    <span v-if="render.search_client">
                        <!-- CLIENTS ROW -->
                	    <div class="row">
						<!-- CLIENTS COL -->
                	        <div class="col-12 col-sm-10 col-md-10 col-lg-9 col-xl-8 mx-auto">
                                <!-- CLIENTS SEARCH LIST --> 
                                    <div class="card no-border"> 
                                        <div class="card-body bg-light-secondary">
                                        <!-- NEW CLIENT FORM --> 
                                            <client-dropdown></client-dropdown>

                                        <!-- CLIENTS CARD-SUBTITLE --> 
                                            <div class="card-subtitle h4"> 
                                                <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                                                Results...
                                            </div>

                                            <hr class="mt-1"/>
                                            <consultation-modal></consultation-modal>
                                            <!-- CLIENT LIST -->
                                            <client-list :init="false"> </client-list>
                                            
                                        </div>
                                    </div>
        			    	</div>
                		</div>	
                    </span>

                    <span v-else>
                        <!-- CONTENT  -->	
                            @yield('content')
                        <!-- ../CONTENT  -->
                    </span>

                </div><!-- ../COL -->

    	  	</div><!--../Row -->
        </div><!--../Container-fluid -->
    @endif
        <event-registry></event-registry>
        <client-lock-screen 
            :header="true"
            :pre-content="true"
            :content="true"
            route='/api/lock-screen'>

            <div slot="header">
                <small class="text-dark font-weight-bold">
                    Screen is locked.
                </small>
                <quick-login></quick-login>
            </div>
        
            <div slot="preContent">
                <div class="form-row">
                    <div class="col-11">
                    <client-form-status></client-form-status>

                    <lang-select></lang-select>

                    <credentials-form></credentials-form>
                    </div>
                </div>
            </div>

            <div slot="content">
                <div class="form-row">
                    <div class="col-11">
                    <medical-form></medical-form>
                    
                    <stress-level-form></stress-level-form>

                    <skin-products-form></skin-products-form>

                    <medications-form></medications-form>

                    <allergies-form></allergies-form>

                    <illnesses-form></illnesses-form>

                    <surgeries-form></surgeries-form>
                    
                    <terms-conditions></terms-conditions>
                    </div>
                </div>
            </div>
        </client-lock-screen>
    @guest
    <!--  FOOTTER NAVIGATION -->
    <ul class="nav justify-content-end fixed-bottom bg-light">
        <li class="nav-item px-0">
            <a class="nav-link disabled pr-2" href="#">
                Actions <i class="fa fa-angle-double-right fa-lg" aria-hidden="true"></i>
            </a>
        </li>
        <li class="nav-item">
            <a @click="showLockScreenModal()" class="nav-link pl-0" href="#">Client Form</a>
        </li>
    </ul>
    @endguest
</div><!--../APP-DIV -->

<script src="{{ secure_asset('js/app.js') }}"></script>


<!-- CUSTOM JS FILES -->
@yield('custom-js')

</body>
</html>
