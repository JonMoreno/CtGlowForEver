<template>
<div>

<!-- Paginantion -->
	<ul class="pagination mb-1 mt-3">
        	    <li class="page-item disabled">
        	        <a class="page-link font-weight-bold text-primary" href="#">
						<i class="fa fa-info-circle fa-lg text-info" aria-hidden="true"></i> 
        	           	MEDICAL INFORMATION
						<br/>
						<span class="font-weight-normal text-muted">
							This is your client's medical history. Please, keep it up to date.
						</span>
        	        </a>
             </li>            	
        </ul><!-- ../Pagination -->
 
		
	<hr class="my-0"/>
		  
    <!-- div-row -->
        <div class="row">

			<transition 
				name="custom-classes-transition"
				enter-active-class="animated wobble"
    			leave-active-class="animated zoomOut"
			>
				<alert-warning :state="alert.warning" class="col-11 col-sm-11 col-md-11 col-lg-8 mt-2 mx-auto">
					<span slot="alert-header">Incomplete!</span>
					<div slot="alert-body" class="text-center" >
						<span class="gfe-text-red text-capitalize">{{ record.client.name }} </span> 
							does not have a medical record yet!
							<br/> 
							<strong> Should we create one?</strong>
							<br/>
						<small>PS: When adding a new client a medical record needs to be completed.</small>
					</div>
					<div slot="alert-footer">
						<div class="text-center">
							<button v-if="alert.warning" @click="broadCastOnCreateBtn()" 
									type="button" class="btn btn-primary btn-lg px-5 py-0">
									Let's create one!
							</button>
						</div>
					</div>
				</alert-warning>
			</transition>

			<transition 
				name="custom-classes-transition"
				enter-active-class="animated flash"
    			leave-active-class="animated zoomOut"
			>
				<alert-success :state="alert.success" class="col-11 col-sm-11 col-md-11 col-lg-8 mt-2 mx-auto">
					<span slot="alert-header">Well Done! </span>
					<div slot="alert-footer" class="text-center">
						<strong>
							<span class="gfe-text-red text-capitalize">{{ record.client.name }} </span>
							now has a medical record!
							<br/>
							Please, make changes below as frequent as you may need.
						</strong>
					</div>
				</alert-success>
			</transition>

            <slot :parent="record">
        	</slot>
			    		
        </div>
	<!-- ../div-row -->

</div>
</template>


<script type="text/javascript">
//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
window._ = require('lodash');
import AlertSuccess from '../alert/Success.vue'; 
import AlertWarning from '../alert/Warning.vue';

export default {
/*---------------------------------------------------------------
| COMPONENT: CardGroup
|----------------------------------------------------------------
| This vue component will serve as a parent component. All other
| child components inheriting this component's data will have
| reactive data as long as they don't mutate the original
| property-name of parent component. --> this.record.
|
*/


//------------------------------------------------------
// COMPONENTS:
//------------------------------------------------------
	components: {
		'alert-success': AlertSuccess,
		'alert-warning': AlertWarning,
	},

//------------------------------------------------------
// PROPERTIES: 
//------------------------------------------------------
	props: {
		records: String,
	},

//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
	data: function() {
		return {
			alert: {
				success: false,
				warning: false,
			},
			record: '', //passed to child components.
		}
	},

//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
	methods: {
		alertSuccess: function() {
			let vi = this;
			vi.alert.success = true;
			window.setTimeout(function() {
				vi.alert.success = false;
			}, 10000);

		},
	//--------------------------------------------------
	// EVENT HANDLING
	//--------------------------------------------------
		onCloseAlertWarning: function() {
			let vi = this;
			Event.listen('onCloseAlertWarning', function() {
				vi.alert.warning = false;
			});

		},
		onCloseAlertSuccess: function() {
			let vi = this;
			Event.listen('onCloseAlertSuccess', function() {
				vi.alert.success = false;
			});

		},
		onMedicalCreated: function() {
			let vi = this;
			Event.listen('onMedicalCreated', function() {
				vi.alertSuccess();
				vi.alert.warning = false;
			});
			
		},
		broadCastOnCreateBtn: function() {
			Event.fire('onCreateBtn');

		},
		broadCastToAsideNav: function(ref , fullName) {
			Event.fire('onAsideNav', 
				{	
					client: {
						ref: ref,
						name: fullName,
					},
					submenu: {
						clients: true,
						medical: true
					},
				}
			);

		}  
	},

//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
	created: function() {
		this.onMedicalCreated();
		this.onCloseAlertWarning();
		this.onCloseAlertSuccess();
		this.record = JSON.parse(this.records);
		this.broadCastToAsideNav(this.record.client.reference , this.record.client.name);
			
	},
	
	mounted: function() {
		let vi = this;
		window.setTimeout(function() {
			vi.alert.warning = !vi.record.medical.complete;
		}, 1000);
		
	}
} 
</script>
    
       
    
    
    
    
    
    
    
    
    
    
    
    
    
