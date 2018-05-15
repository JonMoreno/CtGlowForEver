// ASIDE MENU TEMPLATE
<template>
	<div class="h-100">
	<!-- Aside Menu Nav -->
		<ul class="nav nav-pills flex-column " role="tablist" aria-orientation="vertical">
		<!-- Client Search Bar -->
			<li class="nav-item  px-1 py-3 pt-md-3 pb-md-2 pl-md-1">
				<div class="input-group">
					<input  type="search" 
							class="form-control" 
							placeholder="Search Client"

							v-model.trim="search.query" 
							@keyup="onSearchClient" 
					>
					<div class="input-group-append">
						<label class="input-group-text bg-white">
							<i class="fa fa-search text-primary" aria-hidden="true"></i>
						</label>
					</div>
				</div>
			</li>
		<!-- Clients -->
			<li class="nav-item">
				<a :class="{active: submenu.clients}" class="nav-link pl-2 pb-1" href="/clients/"> 
					<i aria-hidden="true" class="fa fa-users"></i>
					Clients
				</a>
			</li>
			<!-- Clients Sub Menu -->
				<transition name="slide-fade">
					<div v-if="submenu.clients" class="pb-2 gfe-submenu pl-1">
						<li v-if="client.name" class="nav-item">
							<a class="nav-link gfe-text-red no-action py-0 pl-2">
									<i aria-hidden="true" class="fa fa-user gfe-text-red"></i>
									<span class="text-capitalize">{{client.name}}</span>
							</a>
						</li>
						<li class="nav-item">
							<a v-cloak :href="clientRoute('/details/')" class="nav-link pl-2 py-0 " :class="{'disabled': client.name.length==0}">
								<i class="fa fa-address-card-o" aria-hidden="true"></i>
								Details
								<i aria-hidden="true" :class="{'fa-arrow-left': submenu.details}" class="fa gfe-text-red"></i>
							</a>
						</li>
						<li class="nav-item">
							<a v-cloak :href="clientRoute('/medical/')" class="nav-link pl-2 py-0" :class="{'disabled': client.name.length==0}">
								<i aria-hidden="true" class="fa fa-medkit"></i> 
								Medical
								<i aria-hidden="true" :class="{'fa-arrow-left': submenu.medical}" class="fa gfe-text-red"></i>

							</a>
						</li>
						<li class="nav-item ">
							<a v-cloak :href="clientRoute('/consultation/')" class="nav-link pl-2 py-0" :class="{'disabled': client.name.length==0}"> 
								<i aria-hidden="true" class="fa fa-file-text-o"></i>
								Consultations	
								<i aria-hidden="true" :class="{'fa-arrow-left': submenu.consultations}" class="fa gfe-text-red"></i>
				
							</a>
						</li>
						<li class="nav-item ">
							<a v-cloak :href="clientRoute('/appointment/')" class="nav-link pl-2 py-0" :class="{'disabled': client.name.length==0}"> 
								<i class="fa fa-address-book-o" aria-hidden="true"></i>
								Appointments
								<i aria-hidden="true" :class="{'fa-arrow-left': submenu.appointments}" class="fa gfe-text-red"></i>
				
							</a>
						</li>
					</div>
				</transition>

		<!-- Services -->
			<li class="nav-item">
				<a @click.stop.prevent="services.toggle_submenu = !services.toggle_submenu" :class="{active: submenu.services}" class="nav-link pl-2 pb-1" href="/clients/consultation/">
					<i class="fa fa-file-text" aria-hidden="true"></i>
					Services
				</a>
			</li>
			<!-- Services Sub Menu -->
				<transition name="slide-fade">
					<div v-if="services.toggle_submenu" class="pb-2 gfe-submenu pl-1">
						<li class="nav-item">
							<a v-cloak href="/service-products/" class="nav-link pl-2 py-0">
								<i class="fa fa-cart-plus" aria-hidden="true"></i>
								Products
								<i aria-hidden="true" :class="{'fa-arrow-left': submenu.products}" class="fa gfe-text-red"></i>
							</a> 
						</li>
						<li class="nav-item">
							<a v-cloak href="/service-discounts/" class="nav-link pl-2 py-0">
								<i class="fa fa-ticket" aria-hidden="true"></i>
								Discounts
								<i aria-hidden="true" :class="{' fa-arrow-left': submenu.discounts}" class="fa gfe-text-red"></i>
							</a> 
						</li>
						<li class="nav-item">
							<a v-cloak href="/service-treatments/" class="nav-link pl-2 py-0">
								<i class="fa fa-medkit" aria-hidden="true"></i>
								Treatments
								<i aria-hidden="true" :class="{'fa-arrow-left': submenu.treatments}" class="fa gfe-text-red"></i>
							</a> 
						</li>
					</div>
				</transition>

		<!-- Calendar -->
			<li class="nav-item">
				<a :class="{active :submenu.calendar}" class="nav-link pl-2 pb-1" href="/master-calendar/">
					<i class="fa fa-calendar"></i>
					Calendar
				</a>
			</li>
			<span v-if="submenu.calendar" class="gfe-submenu"></span>
		<!-- Dashboard -->
			<li class="nav-item">
				<a :class="{active :submenu.dashboard}" class="nav-link pl-2 pb-1" href="/dashboard/">
					<i class="fa fa-tachometer" aria-hidden="true"></i>
					Dashboard
				</a>
			</li>
			<span v-if="submenu.dashboard" class="gfe-submenu"></span>
		<!-- Automation -->
			<li class="nav-item">
				<a @click.stop.prevent="automation.toggle_submenu = !automation.toggle_submenu" :class="{active: submenu.automation}" class="nav-link pl-2 pb-1 gfe-text-red" href="/dashboard/">
					<i class="fa fa-lock" aria-hidden="true"></i>
					Lock Screen
				</a>
			</li>
			<!-- Lock Services Sub Menu -->
				<transition name="slide-fade">
					<div v-if="automation.toggle_submenu" class="pb-2 pl-1">
						<li class="nav-item">
							<a v-cloak @click.stop.prevent="broadCastOnLockScreenModal()" href="#" class="nav-link pl-2 py-0 gfe-text-red">
								<i class="fa fa-user-secret" aria-hidden="true"></i>
								New Client
							</a> 
							
						</li>
						<!-- <button @click="broadCastOnClientFormLock()" type="button" class="btn btn-primary" data-toggle="modal">Large modal</button> -->
					</div>
				</transition>
		<!-- Mail -->
			<li class="nav-item">
				<a @click.stop.prevent="mail.toggle_submenu = !mail.toggle_submenu" :class="{active: submenu.mail}" class="nav-link pl-2 pb-1 text-muted" href="/dashboard/">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
					Mail Services
				</a>  
			</li>
			<!-- Services Sub Menu -->
				<transition name="slide-fade">
					<div v-show="mail.toggle_submenu" class="pb-2 gfe-submenu pl-1">
						<li class="nav-item">
							<a v-cloak href="#" class="btn btn-link nav-link pl-2 py-0 text-muted text-left" tabindex="0" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="Feature not available. To add feature contact your developer JonNathan Moreno: @jon-moreno@outlook.com">
								<i class="fa fa-share" aria-hidden="true"></i>
							  	Email Client
							</a> 
						</li>
						<li class="nav-item">
							<a v-cloak href="#" class="btn btn-link nav-link pl-2 py-0 text-muted text-left" tabindex="0" data-trigger="focus" data-container="body" data-toggle="popover" data-placement="top" data-content="Feature not available. To add feature contact your developer JonNathan Moreno: @jon-moreno@outlook.com">
								<i class="fa fa-paper-plane" aria-hidden="true"></i>
							 	Create Campaign 
							</a> 
						</li>
					</div>
				</transition>
		</ul> 
	<!-- ../Aside Menu Nav -->
	</div>
</template>
 
// ASIDE MENU COMPONENT  
<script type="text/javascript">

//------------------------------------------------------
// COMPONENT DEPENDENCIES:
//------------------------------------------------------
window._ = require('lodash');


export default {
	components:{
		// Lock Screen:
	},
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
	data: function() {
		return {
			search: {
				query: '',
				route: '/api/clients/search/',
			},
			client:{
				ref: '',
				name: '',
			},
			services: {
				toggle_submenu: false,
			},
			calendar: { 
				toggle_submenu: false,
			},
			automation:{
				toggle_submenu: false,
			},
			mail:{
				toggle_submenu: false,
			},
			submenu: { // selected sub menu. 
				clients: '',
					details: '',
					medical: '',
					consultations: '',
					appointments: '',
				services: '',
					products: '',
					discounts: '',
					treatments: '',
				calendar: '',
				dashboard: '',
				automation: '',
				mail: ''
			},
		}
	},
//------------------------------------------------------
// COMPUTED PROPERTIES:
//------------------------------------------------------
	computed: {
		/* 
		 * Assemble client's route and search query.
		 */
		searchRoute: function() {
			return '/api/clients/search/' + this.search.query;
		}
	},
//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
	methods: {
		/* 
		 * Assemble client's route depending on the
		 * client reference dynamically changed.
		 */
		clientRoute: function(route) {
			return '/clients'+ route + this.client.ref;

		},
		/**
		 * Load all acitve links into Aside-Menu.
		 * It requires an object with boolean 
		 * true on liks needed to be active.
		 */
		loadNav: _.debounce( function (navObj){ 
			let vi = this;
			if(navObj.submenu != 'undefined') {
				for(let obj in navObj){
					for(let prop in navObj[obj]){
						vi[obj][prop] = navObj[obj][prop];
					}

				}
			}

		}, 200),
		/**
		 * Triggers on input event. This method will 
		 * perform a search query with the given
		 * input value. 
		 */
		onSearchClient: _.debounce( function() {
			const vi = this;
			if(window.location.pathname != '/clients/'){ 
			// If event is triggered outside the client's
			// url page. If query input is not empty
			// render the desired componets and 
			// actions to make the search
			// query happen.
				let renderSearchClient; //boolean to render components.

				if(vi.search.query.length === 0){
					vi.submenu.clients = false;
					renderSearchClient = true;
				}else{ 
					vi.submenu.clients = true; 
					renderSearchClient = false; 
				}
				Event.fire('onRenderSearchClient', renderSearchClient); //render required components.
				setTimeout( function(){ // hold on search while required components render.
					vi.broadCastOnSearchClient( {route: vi.search.route, query: vi.search.query} );
				});
			}else{
				vi.broadCastOnSearchClient( { route: this.search.route , query: this.search.query} );

			}

		},1000),
	//--------------------------------------------------
	// EVENT HANDLING
	//--------------------------------------------------
		/**
		 * When event triggers nullify all menu and
		 * sub-menu links before proper rendering.
		 */
		listenAsideMenuEvents: function() {
			let vi = this;
			Event.listen('onAsideNav', function(client) {	
				// Clear Pre-Defined Nav-Links.			
				for(let prop in vi.submenu){ 
					vi.submenu[prop] = null;
				}
				// Load Current Links.
				vi.loadNav(client);
			});

		},
		/**
		 * Fire event to search for client with 
		 * input query string.
		 */
		broadCastOnSearchClient: function(query){
			Event.fire('onSearchClient', query);

		},
		/**
		 * Listen on event and pass through clients
		 * information to consultation modal via 
		 * the aside nav event.
		 */
		listenOnAsideNavPreLoadConsultation: function() {
			let vi = this;
			Event.listen('onAsideNavPreLoadConsultation', function() {
				if(vi.submenu.consultations){
					const client = { name: vi.client.name, id: vi.client.ref };
					Event.fire('onConsultationModal', client); //open modal with client's data.
				}
			});

		},
		/**
		 * Fire event to display child component.
		 * Component Lock Screen Modal.
		 */
		broadCastOnLockScreenModal: function(){
			const vi = this;
			Event.fire('OnLockScreenModal');
		}
	},
//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
	created: function() {
		this.listenAsideMenuEvents();
		this.listenOnAsideNavPreLoadConsultation();		
	},
	mounted: function(){
		$(function () {
			$('[data-toggle="popover"]').popover()
		})
	}
}
</script>



// ASIDE MENU NAV STYLE
<style scoped>
	.title{
		padding-left: 1px;
		font-size: 110% !important;
		border-bottom: 0.1em  solid #f2f2f2;
	}
	.nav-link{
		font-size: 130%;
	}
	.gfe-submenu{
		border-top: 3px solid #fa5252 !important;
		border-bottom: 2px solid #e1e6ea !important;
		background-color: white;
		margin-top: 1px !important;
	}
</style>
















