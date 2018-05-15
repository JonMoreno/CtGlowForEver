

// CLIENT MODAL TEMPLATE
<template>
<div>
<div class="clearfix mb-2">
	<a v-on:click="toggleForm"  href="#" class="btn btn-primary mb-2 pull-right btn-sm" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
		<slot><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>ADD CLIENT</slot>
  	</a>
</div>
		<div class="collapse" id="toggleForm">
  			<div class="card card-body">
				<!-- Alert Fail -->
				<alert-fail :state='alert.state' class="pb-0"> 
					<strong> Oops! </strong>This is embarassing...
					<br/>
					{{ alert.message }} Please, refresh your browser.
					<br/>
						If the problem persists contact your developer.
					<br/>
					<a href="mailto:jon-moreno@outlook.com">
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
							JonNathan Moreno
					</a>
				</alert-fail>
				<h5 class="title text-primary">
					Basic Form
				</h5>
					
				<form 	action="#"
						method="POST" 
						enctype="multipart/form-data"
						class="form-row needs-validation pl-2" 
						v-on:change="validateInput($event.target.name, true)"
						v-on:keyup="validateInput($event.target.name, true)"
						
				>
				<!-- First Name -->
					<!-- COL -->
					<div class="form-group col-6">
						<label class="col-form-label">
							First Name
						</label>
						<input  name="first_name" 
								type="text" 
								class="form-control form-control-sm" 
								
								v-model.trim="client.first_name"
								v-bind:style="feedback.style('first_name', 'input')"
						>
						<div v-text="feedback.feedback('first_name')"
							 v-bind:style="feedback.style('first_name','feedback')"
						></div>
					</div> <!-- ../COL -->
				<!-- Last Name -->
					<!-- COL -->
					<div class="form-group col">
						<label class="col-form-label">
								Last Name
						</label>
						<input  name="last_name" 
								type="text" 
								class="form-control form-control-sm" 
								
								v-model.trim="client.last_name"
								v-bind:style="feedback.style('last_name', 'input')"
						>
						<div  v-text="feedback.feedback('last_name')"
							  v-bind:style="feedback.style('last_name','feedback')" 
						></div>
					</div> <!-- ../COL -->
				<!-- EMAIL -->
					<!-- COL -->
					<div class="form-group col-6">
						<label class="col-form-label">
							Email <small>(opitional)</small>
						</label>
						<input  type="email" 
								name="email" 
								class="form-control form-control-sm" 

								v-model.trim="client.email"
								v-bind:style="feedback.style('email', 'input')"
								
						>
						<div v-text="feedback.feedback('email')"
							 v-bind:style="feedback.style('email', 'feedback')"
						></div>
						
						
					</div><!-- ../COL -->
				<!-- Mobile -->
					<!-- COL -->
					<div class="form-group col-6">
						<label class="col-form-label">
								Mobile <small>(opitional)</small>
						</label>
						<input  name="cellular" 
								type="phone" 
								class="form-control form-control-sm" 
								
								v-model.trim="client.cellular"
								v-bind:style="feedback.style('cellular', 'input')"
						>
						<div v-text="feedback.feedback('cellular')"
						     v-bind:style="feedback.style('cellular', 'feedback')"
						></div>
					</div> <!-- ../COL -->

				<!-- PROFILE IMAGE -->  
					<div class="form-group col-12">
							
						<div class="text-center pt-2">
							<label class="mb-0">
								<i class="fa fa-file-image-o" aria-hidden="true"></i>
								Client Image <small>(opitional)</small>
							</label>
						</div>
						<div class="text-center" v-bind:style="feedback.style('image', 'feedback')">
							<code class="code">{{ client.image }}</code>
							<br/>
							<span v-text="feedback.feedback('image')"></span>
						</div>
						<div class="text-center">
							<label class="custom-file">
								<input 	name="image" 
										type="file" 
										class="custom-file-input form-control-sm" 
											
										v-on:change="onFileChange"
								>
								<span class="custom-file-control"></span>
							</label>
						</div>
					</div>
     
					<div class="col-12 pt-3 text-center">
						<button type="submit" class="btn btn-primary" v-on:click.stop.prevent="onSubmitForm"> Save Client </button>
						<small class="text-dark font-weight-bold pt-2 d-block">
							This is the fastest way to add a new client and get going...<br/>
							However you will need to fill out a much more detailed form later on.
						</small>
					</div>
				
					
				</form>
  			</div>
		<br/>
		<br/>
		<br/>
		<br/>
		</div>
  
</div>
</template>  


// CLIENT MODAL COMPONENT
<script type="text/javascript">

let timeout = null;
//Lodash_________________________________________
window._ = require('lodash');

//Components_____________________________________
import AlertFail from '../alert/Fail.vue';

//Utilies________________________________________
import FeedBack from "../utilities/feedback_v2.js";
import Rules from "./forms/client_drowpdown_rules.js";
import Validation from "../utilities/validation.js";


export default {

	components: {
		'alert-fail': AlertFail,

	},
    data: function() {
		return {
			client: {
				image: '',
				email: '',
				cellular: '',
				last_name: '',
				first_name: '',

			},
			alert: {
				state: false,
				message: null,

			},
			form: new Validation(),
			formData: new FormData(),
			feedback: new FeedBack(),
			route: '/api/clients', 
						
		}
	
	}, 
    methods: {
		test: function(e) {
			alert(e);
			console.log(e);
		},
	// Form events.
		toggleForm: function() {
			$('#toggleForm').collapse('toggle');

		},
		onFileChange: function (value) {
			this.client.image = (Math.random().toString(36).substring(7)) + value.target.files[0].name; 
			this.formData.append('file', value.target.files[0]);
			this.validateInput('image'); 
			

		},
		onSubmitForm: function () {
			let vm = (this); let fields = Object.keys(this.client); 
			if(vm.validateForm()) { 
				for(let input in fields){ 
					if(vm.client[fields[input]].length > 0){
						vm.formData.append([fields[input]] , vm.client[fields[input]]);	
					}
				}
				vm.storeData(vm.formData); 
 
			}

		},
	//form methods.
		isValid: function(field) {
			let feedback = (this.feedback);  let form = (this.form);
			feedback.setStyle(field, 'input', 'valid'); 
			feedback.setStyle(field, 'feedback', 'valid');
			feedback.setFeedBack(field, 'looks great!');
			return true;

		},
		isInvalid: function(field) {
			let feedback = (this.feedback); let form = (this.form);
			feedback.setStyle(field, 'input', 'invalid');
			feedback.setStyle(field, 'feedback', 'invalid');
			feedback.setFeedBack(field, form.getMessage(field));
			return false;
			
		},
		validateForm: function(){
			let ready = true; let form = Object.keys(this.client); let vm = (this); 
			for(let field in form){
				!vm.validateInput([form[field]]) ? ready = false : null ;
			}
			return ready;

		},
		validateInput: function(field , wait = false) { 

			let vm = (this);

			if(wait) {
				clearTimeout(timeout);
				timeout = setTimeout( function() {
					if(vm.form.validate(field, vm.client[field])){
						return vm.isValid(field); 
					}
					return vm.isInvalid(field); 
				}, 600);
			}else{
				if(vm.form.validate(field, vm.client[field])){
					return vm.isValid(field); 
				}
				return vm.isInvalid(field); 
			}
				
		},
	//http requests.
		storeData: function(formData) {
			let vm = (this);
			axios.post(vm.route , formData)
				.then( function(response) {
					vm.toggleForm();
					vm.broadCastToClientList();
				})
				.catch( function(error){
					if(error.response.data.errors) {
						let errors = error.response.data.errors;
						for(let prop in errors){
							vm.feedback.setStyle(prop , 'input', 'invalid');
							vm.feedback.setStyle(prop , 'feedback', 'invalid');
							vm.feedback.setFeedBack(prop , errors[prop][0]);

						}

					}else{
						vm.alert.state = true;
						vm.alert.message = "Unfortunately we could not process your form at this time.";

					}

				});

		},
	//broadcast to other components.
		broadCastToClientList: function() {
			Event.fire('onRefreshList');
			
		},
	//upon component mounting initialize required data.
		init: function() { // overcome vue's data reactivity.
			let fields = Object.keys(Rules); let vm = (this); let feedback = (this.feedback);
			for(let field in fields){ // set form's reactive data.
				vm.$set(feedback.styleFeedBacks, [fields[field]], '', );   	
				vm.$set(feedback.styleInputs, [fields[field]], '', );   
				vm.$set(feedback.messages, [fields[field]], '' ); 

			}
			vm.form.setRules(Rules); // set form rules.
			Event.listen('close_alert', function() { // listen to alert-fail component when closed.
				vm.alert.state = false;
				vm.alert.message = null;

			})

		},
		
	},
    mounted: function() {   
		this.init();
    	    
    }
    
}

</script>


// CLIENT MODAL STYLING
<style scoped>

.code {
	font-size: 12px !important;
}

</style>


