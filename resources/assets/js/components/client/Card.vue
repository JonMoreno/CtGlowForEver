// CLIENT TEMPLATE
<template>
	<div>

	<!-- Client-Card -->
		<div class="card border-light-secondary">
		<!-- Client-Card-Body -->
			<div class="card-body pb-0" @click="onSelect(client.id, fullName)" :class="card.body">

				
				<div class="pull-left">
					<span v-if="client.dob != null" class="btn badge-light text-primary border-light-secondary mr-1 px-1 font-weight-bold">{{ age }}y/o</span>
					<a  tabindex="0" 
						role="button" 
						v-if="isBirthDay"
						data-trigger="focus" 
						data-placement="top"
						data-toggle="popover" 
						title="Birthday Reminder" 
						class="btn btn-light gfe-text-red border-light-secondary py-0 px-1" 
						data-content="Today is your client's birth day. Please, express to them your best whishes!">
						<i class="fa fa-gift gfe-text-red fa-2x" aria-hidden="true"></i>
					</a>
				</div>
				

				<transition name="fade">
					<div v-if="!client.complete" class="clearfix">

						<button type="button" class="badge badge-pill badge-warning pull-right"  :id="customID"
								data-placement="top"  data-html="true" 
								title="This badge is here because you have not yet completed all the client's details or medical record.">
							Incomplete!
						</button>

					</div>	
					<div v-else class="clearfix">
						<span class="badge badge-pill badge-primary pull-right">
							Completed!
						</span>
					</div>
				</transition>

				<div class="row">
					<div class="col-12 col-md-6 order-2 order-sm-2 order-sm-2 order-md-1 d-flex flex-column align-self-center ">
						<h4 class="card-title text-center mb-3 text-capitalize">
							{{ client.first_name + ' ' + client.last_name }}
						</h4>  
						<h6 class="card-subtitle text-center text-muted" >
							<span class="font-weight-bold">Phone: </span>
							{{ formatPhoneNumber }}
						</h6>

						<p v-if="consultation" class="card-text mt-3" :class="{'text-muted': disabled}">
							{{consultation.notes}}
						</p>	

						<!-- Button trigger consultation modal -->
						<transition name="fade">
							<button 
								v-if="!disabled"
								@click="broadCastOnConsultationModal()"

								type="button"
								data-toggle="modal" 
								data-target="#exampleModalCenter"
								class="btn btn-primary btn-block ls-1 mt-4"  
							>
								<i class="fa fa-cart-plus fa-lg" aria-hidden="true"></i> Consultation 
							</button>
						</transition>

							<p v-if="consultation.created_at" class="text-center font-italic text-muted mt-2">
								Last Visit: <span class="gfe-text-lred">{{ consultation.created_at}} </span>
							</p>
							<p v-else class="absolute-bottom text-center font-italic text-muted">
								New Customer
							</p>
							
					</div>      	        
					<div class="d-flex col-12 col-md-6 order-sm-1 order-md-2 justify-content-center align-self-center">
						<img :src="client.image " class="img-fluid rounded-circle" >
					</div>
				</div>   
			</div><!--../Client-Body -->
		</div><!--../Client-Card -->

		<transition name="fade">
			<span v-if="!disabled">
		<!-- Remove Client Button -->
			<div class="clearfix">
				<button @click="onRemove(index, client.id)" type="button" class="btn btn-outline-danger btn-sm px-1 py-0 pull-right">
					Remove Client
				</button>
			</div>
		<!-- ../Remove Client Button -->
			</span>
		</transition>
	</div>
</template>  


// CLIENT COMPONENT
<script type="text/javascript">
//------------------------------------------------------
// COMPONENT DEPENDENCIES
//------------------------------------------------------  
import Moment from 'moment';
import ConsultationModal from '../consultation/create/Modal.vue'; 

export default {
/*---------------------------------------------------------------
| COMPONENT: Consultaion\Create
|----------------------------------------------------------------
| This will serve as way to display the client's brief information
|
*/


//------------------------------------------------------
// CHILD COMPONENTS:
//------------------------------------------------------
    components:{
		'consultation-button': ConsultationModal
	},

//------------------------------------------------------
// COMPONENT PROPS
//------------------------------------------------------
    props:{
		info: {
			type: [String,Object],
			required: true
		},
		index: {
			type: [Number],
			required: true
		},
		toggle: {
			type: [String,Number],
			required: true
		}
	},

//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function() {
		return {
			disabled : true,
			client: '',
			consultation: '',
			customID: '',
			card:{
				body: '',
				button: 'disabled',
			},
			route: '/api/latest-consultation'
		}
	}, 

//------------------------------------------------------
// WATCHED PROPERTIES:
//------------------------------------------------------
	watch: {
		toggle: function(select) {
			select == this.client.id ? this.applyStyle() : this.disableStyle() ;
		}

	},

//------------------------------------------------------
// COMPUTED PROPERTIES:
//------------------------------------------------------
	computed: {
		fullName: function(){
			return this.client.first_name + ' ' + this.client.last_name;
		},
		formatPhoneNumber: function(){
			let cell = this.client.cellular;
			var s2 = (""+cell).replace(/\D/g, '');
			var m = s2.match(/^(\d{3})(\d{3})(\d{4})$/);
			return (!m) ? null : "(" + m[1] + ") " + m[2] + "-" + m[3];

		},
		age: function(){
			const formatDOB = Moment(this.client.dob, 'MM-DD-YYYY');
			return Moment().diff(formatDOB, "years");
		},
		isBirthDay: function(){
			if(Moment().format('MM-DD') == Moment(this.client.dob, 'MM-DD-YYYY').format('MM-DD')){
				return true;
			}
			return false;
		}

	},

//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
    methods: {
	//--------------------------------------------------
	//  CLASS & STYLE BINDING
	//--------------------------------------------------
		disableStyle: function() {
			this.disabled = true;
			this.card.body = "";

		},
		applyStyle: function() {
			this.disabled = false;
			this.card.body = "bg-light-primary";
			
		},
	//--------------------------------------------------
	// EVENT HANDLING:
	//--------------------------------------------------
		broadCastOnConsultationModal: function() {
			Event.fire('onConsultationModal', this.client);

		},
		onRemove: function(index , id) {
			Event.fire('onRemoveClient', 
				{ 	index: index, 
					ref: id 
				} 
			);

		},
		onSelect: function (id = false , fullName = false){	
			Event.fire('onSelectClient', 
				{ 
					ref: id,
					name: fullName
				}
			);

		},
	//--------------------------------------------------
	// HTTP REQUESTS:
	//--------------------------------------------------
		showConsultation: function() {
			let vi = this;

			axios.get(vi.route + '/' + vi.client.id)
				.then( function(response) {
					vi.consultation = response.data;
				})
				.catch( function () {
					console.log('Card.showConsultation() ERROR:');
				});

		}
	},

//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
    created: function() {
		const vi = this;
		vi.client = this.info;
		vi.customID = 'client' + vi.client.id;
		$(function () {
			$('#'+vi.customID).tooltip()
		})

		vi.showConsultation();		
	}
}
</script>


// CLIENT STYILING
<style type="scoped">

</style>