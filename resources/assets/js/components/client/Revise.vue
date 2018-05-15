

// CLIENT REVISE TEMPLATE
<template>
	<div> 
		<!-- REVISE CLIENT FORM -->
		<form 	enctype="multipart/form-data"
				method="POST" 
				action="#" 

				v-on:keyup="validateField($event.target.name)" 
				v-on:change="validateField($event.target.name)"
				v-on:click="applyCaret($event.target.name)"
		>

		<!-- CARD -->
			<div class="card border-light-secondary">
			<!-- Alert Fail -->
				<alert-fail :state='alert.fail.state' class="pb-0"> 
					<strong> Oops! </strong>This is embarassing...
					<br/>
					{{ alert.fail.msg }} Please, refresh your browser.
					<br/>
					If the problem persists contact your developer.
					<a href="mailto:jon-moreno@outlook.com">
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
							JonNathan Moreno
					</a>
				</alert-fail> 
			
			<!-- Client-Card-Body -->
				<div v-if="alert.view" class="card-body	">
					
					<!-- Incomplete or Missing information -->
						<transition 
						name="custom-classes-transition"
						enter-active-class="animated wobble"
						leave-active-class="animated zoomOut"
						>
							<alert-warning :state="alert.warning" class="col-11 col-sm-11 col-md-11 col-lg-11 mx-auto">
								<span slot="alert-header">Missing Information!</span>
								<div slot="alert-body">
									Very little or no information has been given for this client. Please, add other information such as phone number, email and so on.
								</div>
							</alert-warning>
						</transition>					

				<!-- FORM ROW GRID -->
					<div class="row">
						<div class="col-12 mx-auto clearfix">
							<div class="card-subtitle text-muted pl-3 pt-1 pull-left"> 
								Last updated {{ client.updated_at }}.
							</div>

							<button class="btn btn-danger pull-right py-1 px-2" v-on:click.prevent.stop="edit = !edit">
								<span v-if="edit"> Editing...</span>
								<span v-else> Edit </span>
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</button>
						</div>
					
						<div class="mx-auto col-12 col-sm-9 col-md-11 col-lg-8">
							
						<!-- CREDENTIALS -->
							<legend> 
								<small class="text-primary">
									<i class="fa fa-plus-square-o" aria-hidden="true"></i>
										Credentials:
								</small>
								<div class="pull-right d-flex align-items-baseline">
									<span v-if="client.dob != null" class="badge badge-light text-primary border-light-secondary mr-2">{{ age }}y/o</span>
									<transition name="bounce">
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
									</transition>
								</div>
							</legend>

						<!-- FIRST NAME FIELD -->
							<!-- form-row -->
							<div class="form-row pl-3">
								<!-- form-group col -->
								<div class="form-group col-12">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										First Name: 
									</label>
									<span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
										{{ client.first_name }}
										<span v-show="editing.first_name">
											<i class="fa fa-caret-left fa-lg text-primary"></i> 
											<hr	class="my-0"/>
										</span>
									</span>
									<input	type="text" 
											name="first_name"
											placeholder="First Name..." 
											class="form-control "
										
											v-show="edit"
											v-model.trim="client.first_name"
											v-bind:class="feedback.style('first_name')" 
									>
									<div class="invalid-feedback">
										{{ feedback.get('first_name') }}
									</div>
										
								</div><!-- ../form-group col -->
							
							<!-- MIDDLE INITIAL FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-md-6">	
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Middle Initial: 
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.mid_initial }}
										<span v-show="editing.mid_initial">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	type="text" 
											name="mid_initial"
											placeholder="Middle Initial..." 
											class="form-control " 

											v-show="edit" 
											v-model.trim="client.mid_initial"
											v-bind:class="feedback.style('mid_initial')" 
									> 
									<div class="invalid-feedback">
										{{ feedback.get('mid_initial') }}
									</div>   
								</div><!-- ../form-group col -->
								
							<!-- LAST NAME FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-md-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Last Name: 
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.last_name }}
										<span v-show="editing.last_name">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	type="text" 
											name="last_name"
											placeholder="Last Name..."
											class="form-control " 

											v-show="edit" 
											v-model.trim="client.last_name"  
											v-bind:class="feedback.style('last_name')" 
									>  
									<div class="invalid-feedback">
										{{ feedback.get('last_name') }}	
									</div>  
								</div><!-- ../form-group col -->
									
							</div><!-- ../form-row -->

							<hr class="mb-3"/>	    	
								
						<!-- CONTACT -->    
							<legend> 
								<small class="text-primary">
									<i class="fa fa-plus-square-o" aria-hidden="true"></i>
									Contact:
								</small>
							</legend>

						<!-- MOBILE PHONE FIELD -->
							<!-- form-row -->
							<div class="form-row pl-3">
								<!-- form-group col -->
								<div class="form-group col-12">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Mobile:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.cellular }}
										<span v-show="editing.cellular">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	type="text" 
											name="cellular"
											placeholder="Mobile..."
											class="form-control " 

											v-show="edit" 
											v-model.trim="client.cellular" 
											v-bind:class="feedback.style('cellular')"
									>
									<div class="invalid-feedback" v-text="feedback.get('cellular')"></div> 
								</div><!-- ../form-group col -->

							<!-- WORK PHONE -->
								<!-- form-group col -->
								<div class="form-group col-12 col-md-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Work:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.work_phone }}
										<span v-show="editing.work_phone">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
										
									</span>
									<input 	type="text" 
											name="work_phone"	
											placeholder="Work Phone..."
											class="form-control " 

											v-show="edit" 
											v-model.trim="client.work_phone" 
											v-bind:class="feedback.style('work_phone')"
									>
									<div class="invalid-feedback" v-text="feedback.get('work_phone')"></div> 
								</div><!-- ../form-group col -->

							<!-- EMERGENCY PHONE FIELD -->	
								<!-- form-group col -->
								<div class="form-group col-12 col-md-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Emerg:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.emergency_phone }}
										<span v-show="editing.emergency_phone">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	type="text" 
											name="emergency_phone"
											placeholder="Emergency Phone..."
											class="form-control " 
											v-show="edit"    
											v-model.trim="client.emergency_phone"  
											v-bind:class="feedback.style('emergency_phone')"
									>
									<div class="invalid-feedback" v-text="feedback.get('emergency_phone')"></div> 
								</div><!-- ../form-group col -->
									
							</div><!-- ../form-row -->

							<hr class="mb-3"/>             	    
								
						<!-- LIVING -->    
							<legend > 
									<small class="text-primary">
										<i class="fa fa-plus-square-o" aria-hidden="true"></i>
										Living:
									</small>
							</legend>
							<!-- form-row -->
							<div class="form-row pl-3">
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-4 col-lg-3">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Apt:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.apt_floor }}
										<span v-show="editing.apt_floor">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	type="text" 
											name="apt_floor"
											placeholder="Apt Number/Floor..." 
											class="form-control " 

											v-show="edit"    
											v-model="client.apt_floor" 
											v-bind:class="feedback.style('apt_floor')"
									>
									<div class="invalid-feedback" v-text="feedback.get('apt_floor')"></div> 
								</div><!-- ../form-group col -->

							<!-- STREET FIELD -->						
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-8 col-lg-9">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Street:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.street }}
										<span v-show="editing.street">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	type="text"  
											name="street"
											placeholder="" 
											class="form-control "

											v-show="edit"    
											v-model="client.street"
											v-bind:class="feedback.style('street')" 
									>
									<div class="invalid-feedback" v-text="feedback.get('street')"></div> 
								</div><!-- ../form-group col -->

							</div><!-- ../form-row -->
								
						<!-- CITY FIELD -->
							<div class="form-row pl-3">
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-5 col-lg-5">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										City:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.city }}
											<span v-show="editing.city">
												<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
												<hr class="my-0"/>
											</span>
									</span>
									<input 	type="text"
											name="city" 
											placeholder="City..."
											class="form-control "

											v-show="edit"    
											v-model="client.city" 
											v-bind:class="feedback.style('city')"
									>
									<div class="invalid-feedback" v-text="feedback.get('city')"></div> 
								</div><!-- ../form-group col -->

							<!-- STATE FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-3 col-lg-3">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										State:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.state }}
										<span v-show="editing.state">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<select name="state"
											class="form-control  "
										
											v-show="edit"
											v-model.trim="client.state"
											v-bind:class="feedback.style('state')" 
									>
										<option value="">Select your state</option>
										<option v-for="(state, index) in states" v-bind:key="index" v-bind:value="state">{{ state }}</option>
									</select>
									<div class="invalid-feedback" v-text="feedback.get('state')"></div> 
									
								</div><!-- ../form-group col -->

							<!-- ZIP CODE FIELD -->					
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-4 col-lg-4">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Zip:
									</label>
									<span v-bind:class="{'font-weight-bold' : edit}" class="d-inline-block" >
										{{ client.zip }}
										<span v-show="editing.zip">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<input 	name="zip"
											type="text"
											placeholder="Zip Code..."
											class="form-control " 
											
											v-show="edit"    
											v-model.trim="client.zip" 
											v-bind:class="feedback.style('zip')"
									>
									<div class="invalid-feedback" v-text="feedback.get('zip')"></div> 
								</div><!-- ../form-group col -->
								
							</div><!-- ../form-row -->

							<hr class="mb-3"/>             	    
						<!-- Other -->    
							<legend > 
									<small class="text-primary">
										<i class="fa fa-plus-square-o" aria-hidden="true"></i>
										Other Details:
									</small>
							</legend>
							<div class="form-row pl-3">

							<!-- DATE OF BIRTH FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-5 col-lg-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										DOB:
									</label>
									<span class="d-inline-block" >
										{{ client.dob }}
											<span v-show="editing.dob">
												<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
												<hr class="my-0"/>
											</span>
									</span>
									<input 	type="text"
											name="dob" 
											placeholder="mm/dd/yyyy..."
											class="form-control "

											v-show="edit"    
											v-model.trim="client.dob" 
											v-bind:class="feedback.style('dob')"
									>
									<div class="invalid-feedback" v-text="feedback.get('dob')"></div> 
								</div><!-- ../form-group col -->

							<!-- GENDER FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-4 col-lg-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Gender:
									</label>
									<span class="d-inline-block" >
										{{ client.gender }}
										<span v-show="editing.gender">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<select name="gender"
											class="form-control "
										
											v-show="edit"
											v-model="client.gender"
											v-bind:class="feedback.style('gender')" 
									>
										<option>Please select one</option>
										<option>female</option>
										<option>male</option>
										<option>other</option>
									</select>
									<div class="invalid-feedback" v-text="feedback.get('gender')"></div> 
									
								</div><!-- ../form-group col -->

							<!-- FIRST FACIAL FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-3 col-lg-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										First Facial:
									</label>
									<span class="d-inline-block" >
										{{ client.first_facial ? 'Yes' : 'No' }}
										<span v-show="editing.first_facial">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<select name="first_facial"
											class="form-control "
										
											v-show="edit"
											v-model="client.first_facial"
											v-bind:class="feedback.style('first_facial')" 
									>
										<option>Please make a selection</option>
										<option value="1">Yes</option>
										<option value="0">No</option> 
									</select>
									<div class="invalid-feedback" v-text="feedback.get('first_facial')"></div> 
									
								</div><!-- ../form-group col -->
							
							<!-- OCUPATION FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-3 col-lg-6">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Occupation:
									</label>
									<span class="d-inline-block" >
										{{ client.occupation }}
											<span v-show="editing.occupation">
												<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
												<hr class="my-0"/>
											</span>
									</span>
									<input 	type="text"
											name="occupation" 
											placeholder=""
											class="form-control "

											v-show="edit"    
											v-model.trim="client.occupation" 
											v-bind:class="feedback.style('occupation')"
									>
									<div class="invalid-feedback" v-text="feedback.get('occupation')"></div> 
									
								</div><!-- ../form-group col -->
								
							<!-- REASON FOR VISIT FIELD -->
								<!-- form-group col -->
								<div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
									<label class="col-form-label">
										<i class="fa fa-minus-square-o text-primary"></i>
										Reason for visit:
									</label>
									<br/>
									<span>
										{{ client.visit_reason }}
										<span v-show="editing.visit_reason ">
											<i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
											<hr class="my-0"/>
										</span>
									</span>
									<textarea 	rows="4"
												name="visit_reason"
												class="form-control" 

												v-show="edit"    
												v-model="client.visit_reason " 
												v-bind:class="feedback.style('visit_reason')"

									>
									</textarea>
									<div class="invalid-feedback" v-text="feedback.get('visit_reason')"></div> 
								</div><!-- ../form-group col -->
								
							</div><!-- ../form-row -->

						</div><!--../mx-auto col -->

					<!-- PROFILE IMAGE FIELD -->
						<div class="mx-auto col-12 col-sm-8 col-md-6 col-lg-4">
							<br/>
							<hr class="mb-3"/>   
							<div class="card card-body" v-bind:class="style_image">
								<div class="card-header text-primary text-center">
									<i class="fa fa-file-image-o" aria-hidden="true"></i>
									Client Profile Image:
								</div>
									<!-- User Profile Image -->
									<div class="text-center" v-show="client">
										<img  v-bind:src="client.image" class="img-fluid rounded img-thumbnail" />   
									</div>    
							<div class="card-footer">
								<span v-show="edit">
										<div class="text-primary text-center" v-text="feedback_image"></div>
										<div class="custom-file">
											<input name="image" 
													type="file" 
													v-on:change="onFileChange"
													class="custom-file-input" >

											<label class="custom-file-label" for="customFile">Choose file</label>
										</div>
								</span>
							</div>
							</div>  
							<br/>
						</div>
					
					
					</div>  	     
				</div><!--../Client-Body -->
				<div class="card-footer mt-4"></div>
			</div><!-- ../CARD -->
		</form><!-- ../Revise Client Form -->
		
	</div>
</template>


// CLIENT REVISE COMPONENET
<script type="text/javascript">
//------------------------------------------------------
// COMPONENT DEPENDENCIES:
//------------------------------------------------------
window._ = require('lodash');
import Moment from 'moment';
import AlertFail from '../alert/Fail.vue';
import UsaStates from "./forms/usa_states.js";
import FeedBack from "../utilities/feedback.js";
import AlertWarning from '../alert/Warning.vue';
import Validation from "../utilities/validation.js";
import FormRules from "./forms/client_basic_rules.js";

export default {
//------------------------------------------------------
// CHILD COMPONENTS:
//------------------------------------------------------
	components: {
		'alert-fail': AlertFail,
		'alert-warning': AlertWarning
	},

//------------------------------------------------------
// COMPOENT PROPS:
//------------------------------------------------------
	props: {
	    record: '',
	    
	},

//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
	data: function() {
		return { 
			client: {},
			route: '/api/clients/',
			edit: false,
			editing: {},
			alert: {
				view: true,
				warning: false,
				fail: {
					msg: '',
					state: false,
				}
			},
			states: [],
			style_image: '',
			feedback_image: '',
			form: new Validation(),
			feedback: new FeedBack(),

		}
	},

//------------------------------------------------------
// COMPUTED PROPERTIES:
//------------------------------------------------------
	computed:{
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
	// FORM EVENTS
	//--------------------------------------------------
		applyCaret: function(field){
			let property = Object.keys(this.editing);
			this.editing[field] = true;
			for(let name in property){
				if(property[name] !== field){
					this.editing[property[name]] = false;
				}
				
			}			

		},
		onCloseAlertFail: function() {
	   		let vi = (this);
	    	Event.listen('close_alert', function() {
				vi.alert.view = true;
				vi.alert.fail.msg = '';
				vi.alert.fail.state = false;
		
	    	});
		},
	//--------------------------------------------------
	// FROM VALIDATION
	//--------------------------------------------------
		validateField: _.debounce(function(field) {
			if(field !== 'image') {
				let vi = (this); 		
				if(vi.form.validate(field, vi.client[field])){		// validation checkpoint.
					field === 'first_name' || field === 'last_name' ? vi.broadCastToAsideNav(): '';					
					vi.feedback.style(field, 'is-valid');
					vi.feedback.set(field, '');
					vi.updateData(field);	
					
				}else{
					vi.feedback.set(field , vi.form.getMessage(field));
					vi.feedback.style(field, 'is-invalid');
				}
			}

		}, 500),
	//--------------------------------------------------
	// EVENT HANDLING
	//--------------------------------------------------
		onCloseAlertWarning: function() {
			let vi = this;
			Event.listen('onCloseAlertWarning', function() {
				vi.alert.warning = false;
			});

		},
		broadCastToAsideNav: function() {
			const id = this.client.id;
			const name = this.client.first_name+' '+this.client.last_name;
			Event.fire('onAsideNav', 
				{ 	
					client: {
						ref: id,
						name: name,
					},
					submenu: {
						clients: true,
						details: true
					},
				}
			);	

		},
	//--------------------------------------------------
	// HTTP REQUESTS:
	//--------------------------------------------------
		updateData: function(field) {
			let vi = (this);
			axios.patch( vi.route + vi.client.id, {
					[field]: vi.client[field],
					'complete': 1
				})
				.then(function(response) {
					vi.alert.warning = false;
					vi.client.updated_at = response.data.updated_at;
				})
				.catch(function(error) {
					if(error.response.data.errors){ 	// back-end validation failed.
						let errors = error.response.data.errors;
						for(let prop in errors){
							vi.feedback.set( prop, errors[prop][0]);
							vi.feedback.style(prop, 'is-invalid');
						}
						
					}else{								// server encounter an error
						vi.alert.view = false;
						vi.alert.fail.state = true;
						vi.alert.fail.msg = "We could not update this record."

					}
				});

		},
		onFileChange (event) {
			const vi = (this);
			const file = event.target.files[0];
			const fileName = (Math.random().toString(36).substring(7)) + event.target.files[0].name;
			
			const formData = new FormData();
			formData.append( 'file', file );
			formData.append( 'image', fileName );

			axios.post( vi.route + vi.client.id + '/image' ,  formData )
			.then( function(response){
				vi.style_image = 'bg-light-success';
				vi.feedback_image = 'Your image has been uploaded!';
				vi.client.image = response.data.image;
				vi.client.updated_at = response.data.updated_at;

			}).catch( function(error) {
				if(error.response.data.errors){ 	// back-end validation failed.
						const errors = error.response.data.errors;
						vi.feedback_image = errors;
						vi.style_image = 'bg-light-danger';
						
					}else{								// server encounter an error
						vi.alert.view = false;
						vi.alert.fail.state = true;
						vi.alert.fail.msg = "We could not update this record."

					}
			});
			
		},
	//--------------------------------------------------
	// COMPONENT INITIAL DATA
	//--------------------------------------------------
		initData: function() {
			this.client = JSON.parse(this.record); 		// set client props.
			this.states = UsaStates;
			let prop = Object.keys(FormRules);
			for(let name in prop){						// set editing props.
				this.$set(this.editing , [prop[name]] , false );
			}	 

		},
		initValidationRules: function() {
			this.form.setRules(FormRules);	// set rules for form fields.

		},
		initFeedBackFields: function() {
			let fields = Object.keys(FormRules);
			for(let field in fields){	
				this.$set(this.feedback.class, [fields[field]], '' );   // class fields.
				this.$set(this.feedback.messages, [fields[field]], [] ); // messages fields.

			}

		},		    
	},

//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
    mounted: function() {   
		this.initData();
		this.onCloseAlertFail();
		this.onCloseAlertWarning();	 	 
		this.initFeedBackFields();
		this.initValidationRules();
		this.broadCastToAsideNav();
		this.alert.warning = !this.client.complete;
    	    
    }   
}
</script>


// CLIENT REVISE STYLE
<style type="scoped">


</style>


