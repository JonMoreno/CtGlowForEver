//TEMPLATE
<template>

<div v-show="medical.hasRecord" class="col-12 col-sm-12 col-md-12 col-lg-6 mx-auto my-4">

	<!-- Alert Loading: -->
	<alert-loading :state="alert.load"> </alert-loading>

	<!-- Alert Error: -->
	<alert-error :state="alert.error"> </alert-error>

	<div class="card bg-light mx-4">   
			
		<div class="card-body">
			<h4 class="card-title text-primary">
				<i class="fa fa-plus-square-o" aria-hidden="true"></i>
				Allergies:
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
				<a  href="mailto:jon-moreno@outlook.com">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
					JonNathan Moreno
				</a>
			</alert-fail> 
						
		<!-- form-row -->
			<div v-show="view.show" class="form-row pl-3">
				<transition name="bounce">
					<div v-if="view.edit" class="col-12">
						<table class='table table-sm list-group-flush mb-0'>
							<tr>
								<td>
									<input v-on:input="validateForm('name')" v-model="form.name" v-bind:class="feedback.name.style" class="form-control" type="text"  name="name" placeholder="product name...">
									<div class="invalid-feedback">
										{{ feedback.name.message }}
									</div>
								</td>
								<td class="align-start pt-2">
									<a  v-on:click.stop.prevent="storeData()" v-bind:class="submitBtn" class="btn btn-primary btn-sm ls-1" href="">
										<i class="fa fa-floppy-o fa-lg"></i>
										Save
									</a>
								</td>
							</tr>
						</table>
					</div>
				</transition>
				<div class="form-group col-12 over-flow-250" id="overflowAll">
				<!-- RECORD LIST -->
					<table class="table table-sm table-hover mb-0">
						<thead>
							<tr>
								<th>Product Name:</th>
								<th v-show="view.edit === true" >&nbsp;</th>
						</tr>
						</thead>
						<transition-group name="list" tag="tbody">
							<tr v-for="(allergie, index) in allergies" :key="allergie.id">
								<td>{{ allergie.name }}</td>
								<td v-if="view.edit" >
									<a v-on:click.stop.prevent="destroyData( index , allergie.id)" class="btn btn-danger btn-sm" href="#">
										<i class="fa fa-trash-o fa-lg"></i> 
										Delete
									</a>
								</td>
							</tr>		    	   
						</transition-group>
					</table>
				<!-- EMPTY LIST -->
					<div class="list-group">
						<a v-if="allergies.length == 0"
							class="list-group-item list-group-item-action text-center px-2">
							<p class="lead">
								<i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>No allergies recorded.
							</p>
						</a>
					</div>
				</div><!-- ../form-group -->
			</div><!-- ../form-row -->

		</div><!-- ../card-body --> 
		
		<div v-show="view.show" class="card-footer clearfix py-1">
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
| COMPONENT: Allerigie
|----------------------------------------------------------------
| This vue component will handle adding allergies to  
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
	data: function () {
	    return {
			route: '/api/allergies',
			allergies: '',
			medical: {
				reference: '',
				hasRecord: false
			},
			form: {
				id: null,
				medical_id: null,
				name: null,
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
				}
			},
			submitBtn: 'disabled',
			updated_at: ''
	    }
	},

//------------------------------------------------------
// INSTANCE METHODS
//------------------------------------------------------  
	methods: {
	//--------------------------------------------------
	// FORM VALIDATION & METHODS
	//--------------------------------------------------  
	    validateForm: function(field) {
			var input = this.form[field];
			var feedback = this.feedback[field];
			if(input.length >= 2){
				this.submitBtn = null;
				feedback.style = null;
				feedback.style = 'is-valid';
				feedback.message = '';
				
			}else if(input.length == 1){
				this.submitBtn = null,
				this.submitBtn ='disabled';
				feedback.style = null;
				feedback.style = 'is-invalid';
				feedback.message = 'Allergie name is too short';
			}
			else{
				this.submitBtn = null,
				this.submitBtn ='disabled';
				feedback.style = null;
				feedback.style = 'is-invalid';
				feedback.message = 'Allergie name is required'; 
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
				this.allergies = temp;
				this.view.show = true;
				this.allergies.length >= 1 ? this.calcUpdatedAt() : '';
			}catch(error){
				// CRITICAL ERROR
				this.alert.load = false; 
				this.view.show = false; // remove card content 
				this.alert.error = true; 
				console.log('Error: SkinProductBox.indexData' + error);
			}
				
		}, 300 ),
		calcUpdatedAt: function(now = false){
			if(now){
				this.updated_at = '1 second ago';
			}else{
				this.updated_at = this.allergies[0].updated_at;
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
					console.log('Error: AllegieBox.showData' + error);
					vi.alert.fail.state = true;
					vi.alert.fail.msg = 'The allergie list could not be refreshed.';
					vi.view.show = false;// remove card content
					
				});
		
		},
		storeData: function() {
			var vi = (this); 
			vi.submitBtn = 'disabled';
			axios.post( this.route, {
					medical_id: this.medical.reference,
					name: this.form.name,
				})
				.then( function(response) {
					vi.showData();
					vi.form = {};
				})
				.catch( function(error) {
				// BACK-END VALIDATION FALL-BACK
					if(error.response.data.errors){
						vi.feedback.name.style = 'is-invalid';
						vi.feedback.name.message = error.response.data.errors.name[0];
					}
				// SERVER ECOUNTER AN ERROR
					else{
						vi.alert.fail.state = true;
						vi.alert.fail.msg = 'This allergi could not be added.';
						vi.view.show = false;// remove card content
					}
					console.log('Error: AllegieBox.storeData' + error);
				});
			
		},
		destroyData: function( index , ref) {
			var vi = (this);
			var deleted = this.allergies.splice(index, 1); // remove deleted 
			vi.calcUpdatedAt(true);
			axios.delete(this.route + '/' + ref)
				.then( function() {})
				.catch( function(error) {
					// SERVER ECOUNTER AN ERROR
					vi.alert.fail.state = true;
					vi.alert.fail.msg = 'Th could not be removed.';	
					vi.view.show = false;// remove card content
					console.log('Error: AllegieBox.destroyData' + error);
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
// LYFECYCLE HOOKS
//------------------------------------------------------      
	created: function () {
		this.onMedicalCreated();
		this.onCloseAlertFail();
		this.indexData(this.info.allergies);
		this.medical.reference = this.info.medical.id;
		this.medical.hasRecord = this.info.medical.complete;	
		
	    
	}
}
</script>









