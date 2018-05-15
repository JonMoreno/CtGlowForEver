//TEMPLATE
<template>

<div v-show="medical.hasRecord" class="mx-auto col-12 col-sm-12 col-md-12 col-lg-6 mx-auto my-4">
	<!-- Alert Loading: -->
	<alert-loading :state="alert.load"> </alert-loading>

	<!-- Alert Error: -->
	<alert-error :state="alert.error"> </alert-error>

	<div class="card bg-light mx-4">   
			
		<div class="card-body pb-0">
			<h4 class="card-title text-primary">
				<i class="fa fa-plus-square-o" aria-hidden="true"></i>
				Medications:
			</h4>
				
			<!-- Alert Fail -->
			<alert-fail :state='alert.fail.state' class="pb-0"> 
				<strong> Oops! </strong>This is embarassing...
				<br/>
				{{ alert.fail.msg }}
				<br/>
					Please, refresh your browser.
				<br/>
					If the problem persists contact your developer.
				<br/>
				<a href="mailto:jon-moreno@outlook.com">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						JonNathan Moreno
				</a>
			</alert-fail> 
				

			<div v-show="view.show" class="form-row pl-3">
				<transition name="bounce">
					<div v-show="view.edit" class="col-12">
						<table class="table table-sm list-group-flush mb-0">
							<tr class="">
								<td class="pt-4">
									<input v-on:input="validateForm('name')" v-model="form.name" v-bind:class="feedback.name.style"  class="form-control" type="text" placeholder="medication name...">
									<div class="invalid-feedback">
										{{ feedback.name.message }}
									</div>
								</td>
								<td class="pt-4"> 
									<input v-on:input="validateForm('withdrawal_period')" v-model="form.withdrawal_period" v-bind:class="feedback.withdrawal_period.style" class="form-control" type="date" placeholder="mm/dd/yyyy">
									<small class="text-lowercase">
										<i class="fa fa-caret-up fa-lg text-danger" aria-hidden="true"></i> 
										Empty will mark as active user.
									</small>
									<div class="invalid-feedback">
										{{ feedback.withdrawal_period.message }}
									</div>
								</td>
								<td class="align-middle">
									<a  v-on:click.stop.prevent="storeData()" v-bind:class="submitBtn" class="btn btn-primary btn-sm ls-1" href="#">
										<i class="fa fa-floppy-o fa-lg"></i>
										Save
									</a>
								</td>
							</tr>
						</table>
					</div>
				</transition>
				<div class="form-group col-12 over-flow-250">
					<!-- RECORDS LIST -->
					<table class="table table-sm table-hover mb-0">
						<thead>
							<tr>
								<th>Medication Name:</th>
								<th>Withdrawal Date:</th>
								<th v-show="view.edit === true" >&nbsp;</th>
							</tr>
						</thead>
						<transition-group name="list" tag="tbody">
							<tr v-for="(medication, index) in medications" :key="medication.id">
								<td>{{ medication.name }}</td>
								<td>{{ mutateData(medication.withdrawal_period) }}</td>
								<td v-if="view.edit" >
									<a v-on:click.stop.prevent="destroyData( index , medication.id)" class="btn btn-danger btn-sm" href="#">
										<i class="fa fa-trash-o fa-lg"></i> 
										Delete
									</a>
								</td>
							</tr>
						</transition-group>		    	   
					</table>
				<!-- EMPTY LIST -->
					<div class="list-group">
						<a v-if="medications.length == 0"
							class="list-group-item list-group-item-action text-center px-2">
							<p class="lead">
								<i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>No medications recorded.
							</p>
						</a>
					</div>
				</div><!-- ../form-group -->
			</div><!-- ../form-row -->

		</div><!-- ../card-body --> 
		
		<div v-show ="view.show" class="card-footer py-1 clearfix" >
			<div class="float-left text-muted">
			Last updated {{ updated_at }}
			</div>
			<div class="float-right">
			<a href="#" v-on:click.stop.prevent="view.edit = !view.edit" class="card-link">
				Edit
				<i 	aria-hidden="true"
					v-show="view.edit" 
					class="fa fa-pencil-square-o fa-lg"
				></i>
			</a>
			</div>
		</div>
		
	</div><!-- ../card -->
</div><!-- ../col -->

</template>


// COMPONENT 
<script  type="text/javascript">
//------------------------------------------------------
// COMPONENT DEPENDENCIES
//------------------------------------------------------ 
window._ = require('lodash');
import AlertLoading from '../alert/Loading.vue';
import AlertError from '../alert/Error.vue';
import AlertFail from '../alert/Fail.vue';


export default {
/*---------------------------------------------------------------
| COMPONENT: MedicationCard
|----------------------------------------------------------------
| This vue component will handle adding medications to 
| the client's medical record
|
*/


//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------ 
	components: {
	   'alert-loading': AlertLoading,
	   'alert-error': AlertError,
	   'alert-fail': AlertFail
	},

//------------------------------------------------------
// PROPERTIES
//------------------------------------------------------  	
	props: {
	    info: {
			type: Object,
			required: true,
	    }
	},

//------------------------------------------------------
// REACTIVE DATA
//------------------------------------------------------  	
	data: function (){
	    return {
			route: '/api/medications',
			medications: '',
			medical: {
				reference: '',
				hasRecord: false
			},
			form: {
				id: '',
				name: '',
				medical_id: '',
				withdrawal_period: ''
			},
			view:{
				show: false,
				edit: false,
				update: false
			},
			alert: {
				load: true,
				error: false,
				fail:{
					state: false,
					msg: '',
				},
			},
			feedback: {
				name: {
					style: null,
					message: null,
				},
				withdrawal_period: {
					style: null,
					message: null,
				}
			},
			submitBtn: 'disabled',
			updated_at: '',
	    }
	}, 

//------------------------------------------------------
// INSTANCE METHODS
//------------------------------------------------------  
	methods: {
	//--------------------------------------------------
	// FORM VALIDATION & METHODS
	//--------------------------------------------------  
	    mutateData: function(val) { // TESTED !!!
			if(val === null){
				return 'active user';
			}
			return val;
	    },
	    validateName: function(val, feedback) { // TESTED !!!		
			if(val.length >= 2){
				this.submitBtn = null;
				feedback.style = null;
				feedback.style = 'is-valid';
				feedback.message = '';
				
			}else if(val.length == 1){
				this.submitBtn = null,
				this.submitBtn ='disabled';
				feedback.style = null;
				feedback.style = 'is-invalid';
				feedback.message = 'Product\'s name is too short';
			}
			else{
				this.submitBtn = null,
				this.submitBtn ='disabled';
				feedback.style = null;
				feedback.style = 'is-invalid';
				feedback.message = 'Product\'s name is required'; 
			}
	    },
	    validateDate: function(val, feedback) { // TESTED !!!
			var date_format = /^\d{4}-\d{2}-\d{2}$/;
								
			if(val.length == 0 ) {
				this.submitBtn = null; 
				feedback.style = null;
				feedback.style = '';
				feedback.message = '';
			}else if(!date_format.test(val)){
				this.submitBtn = null,
				this.submitBtn = 'disabled';
				feedback.style = null;
				feedback.style = 'is-invalid';
				feedback.message = 'Date must follow this format mm/dd/yyyy'; 
			}else{
				this.submitBtn = null;
				feedback.style = null;
				feedback.style = 'is-valid';
				feedback.message = '';
			}
		 
	    },
	    validateForm: function(field) { // TESTED !!!
			var input = this.form[field];
			var feedback = this.feedback[field];
			if(field == 'name'){
				this.validateName(input, feedback);
			}
			if(field == 'withdrawal_period'){
				this.validateDate(input, feedback);
			}
				
		},
	//--------------------------------------------------
	// INITIAL DATA RENDER
	//--------------------------------------------------
		indexData: _.debounce( function(data){
				try{
					this.alert.load = false; 

					let i = data.length - 1;
					let temp = [];
					for(i ; i >= 0; i--){
						temp.push(data[i]);
					}
					this.medications = temp;
					this.view.show = true;
					this.medications.length >= 1 ? this.calcUpdatedAt() : '';
				}catch(error){
					// CRITICAL ERROR
					this.alert.load = false; 
					this.view.show = false; 
					this.alert.error = true; 
					console.log('Error: MedicationBox.indexData' + error);
				}
				
		}, 300 ),
		calcUpdatedAt: function(now = false){
			if(now){
				this.updated_at = '1 second ago';
			}else{
				this.updated_at = this.medications[0].updated_at;
			}
		},
	//--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
		showData: function() {
			var vi = (this);
			axios.get(this.route + '/' + this.medical.reference)
				.then( function(response) {
					vi.indexData(response.data);
				})
				.catch( function(error) { // Server encounter an error.
					console.log('Error: MedicationBox.showData' + error); 
					vi.alert.fail.state = true;
					vi.alert.fail.msg = 'The medication list could not be refreshed.';
					vi.view.show = false;// remove card content
				});
		
		},
		storeData: function() {
			var vi = (this);
			vi.submitBtn = 'disabled'; // Disable submitting again form 
			for(var field in vi.feedback){ // Clear out form feedback fields.
				for(var prop in vi.feedback[field]){
				vi.feedback[field][prop] = null;
				}
			}
			axios.post( this.route, { // Make axios request.
					medical_id: this.medical.reference,
					name: this.form.name,
					withdrawal_period: this.form.withdrawal_period
				})
				.then( function(response) {
					vi.showData();
					vi.form = {};
				})
				.catch( function(error) {
					// BACK-END VALIDATION FALL-BACK
					if(error.response.data.errors){
						var errors = error.response.data.errors;
						for(var a in errors){
						vi.feedback[a].style = 'is-invalid';
						vi.feedback[a].message = errors[a][0];
						}        			     
					}
					// SERVER ECOUNTER AN ERROR
					else{
						vi.alert.fail.state = true;
						vi.alert.fail.msg = 'This medication could not be added.';
						vi.view.show = false;// remove card content
					}
						console.log('Error: MedicationBox.storeData' + error);
				
				});
			
		},
		destroyData: function( index , ref) {
			var vi = (this);
			var deleted = this.medications.splice(index, 1); // remove deleted
			vi.calcUpdatedAt(true); //just now
			axios.delete(this.route + '/' + ref)
				.then( function() {})
				.catch( function(error) { 
				// SERVER ECOUNTER AN ERROR
					vi.alert.fail.state = true;
					vi.alert.fail.msg = 'This medication could not be removed.';	
					vi.view.show = false;// remove card content
					console.log('Error: MedicationBox.destroyData' + error);
				});
			
		},
	//--------------------------------------------------
	// EVENT HANDLING
	//--------------------------------------------------
		onMedicalCreated: function() {
			let vi = this;
			Event.listen('onMedicalCreated', function(medical) {
				vi.medical.hasRecord = medical.complete;
				vi.medical.reference = medical.reference;
			});
			
		},
		onCloseAlertFail: function() {
			var vi = (this); //PENDING
			Event.listen('onCloseAlertFail', function() {
				vi.view.show = true;
				vi.alert.fail.state = false;
				vi.alert.fail.msg = '';
			});
		},
	},

//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------   
	created: function () {
		this.onMedicalCreated();
		this.onCloseAlertFail();
		this.indexData(this.info.medications);
		this.medical.reference = this.info.medical.id;
		this.medical.hasRecord = this.info.medical.complete;
	},
}
</script>


<style  type="scoped">
td {
    text-transform: capitalize;
}
</style>








