//TEMPLATE
<template>

<div v-show="medical.hasRecord"  class="mx-auto col-12 col-sm-12 col-md-12 col-lg-6 my-4">

	<!-- Alert Loading: -->
	<alert-loading :state="alert.load"> </alert-loading>

	<!-- Alert Error: -->
	<alert-error :state="alert.error"> </alert-error>

	<div class="card bg-light mx-4">   
		<div class="card-body pb-0">
			<h4 class="card-title text-primary">
				<i class="fa fa-plus-square-o" aria-hidden="true"></i>
			Skin Products:
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
			<!-- New Item Form -->	
				<transition name="bounce">
					<div v-show="view.edit" class="col-12">
						<table class="table table-sm list-group-flush mb-0">
							<tr v-if="view.edit" class="">
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
			<!-- List of all items -->
				<div class="form-group col-12 over-flow-250 mb-0">
					<table class="table table-sm table-hover mb-0">
						<thead>
							<tr>
								<th>Product Name:</th>
								<th v-show="view.edit === true" >&nbsp;</th>
							</tr>
						</thead>
						<transition-group name="list" tag="tbody">
							<tr v-for="(skin_product, index) in skin_products" :key="skin_product.id">
								<td>{{ skin_product.name }}</td>
								<td v-if="view.edit" >
									<a v-on:click.stop.prevent="destroyData( index , skin_product.id)" class="btn btn-danger btn-sm" href="#">
										<i class="fa fa-trash-o fa-lg"></i> 
										Delete
									</a>
								</td>
							</tr>
						</transition-group>	
					</table>
				<!-- EMPTY LIST -->
					<div class="list-group">
						<a v-if="skin_products.length == 0"
							class="list-group-item list-group-item-action text-center px-2">
							<p class="lead">
								<i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>No skin products recorded.
							</p>
						</a>
					</div>
				</div>
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
| COMPONENT: SkinProduct
|----------------------------------------------------------------
| This vue component will handle adding skin products for 
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
			route: '/api/skin-products',
			skin_products: '',
			medical: {
				reference: '',
				hasRecord: false,
			},
			form: {
				id: null,
				medical_id: null,
				name: null,
			},
			view:{
				show: false,
				edit: false,
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
	    validateForm: function(field) {
			var form_input = this.form[field];
			var feedback = this.feedback[field];
			if(form_input.length >= 2){
				this.submitBtn = null;
				feedback.style = null;
				feedback.style = 'is-valid';
				feedback.message = '';
				
			}else if(form_input.length == 1){
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
	//--------------------------------------------------
	// INITIAL DATA RENDER
	//--------------------------------------------------
	    // Index <<<- TESTED !!!
		indexData: _.debounce( function(data){
				try{
					this.alert.load = false; 

					let i = data.length - 1;
					let temp = [];
					for(i ; i >= 0; i--){
						temp.push(data[i]);
					}
					this.skin_products = temp;
					this.view.show = true;
					this.skin_products.length >= 1 ? this.calcUpdatedAt() : '';
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
				this.updated_at = this.skin_products[0].updated_at;
			}
		},
	//--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
		showData: function() {
			var component = (this);
			axios.get(this.route + '/' + this.medical.reference)
					.then( function(response) {
						component.indexData(response.data);
					})
					.catch( function(error) { // Server encounter an error.
						console.log('Error: SkinProductsBox.showData' + error);
						component.alert.fail.state = true;
						component.alert.fail.msg = 'The skin product list could not be refreshed.';
						component.view.show = false;// remove card content
						
					});
		
		},
		storeData: function() {
			var component = (this); 
			component.submitBtn = 'disabled';
			axios.post( this.route, {
					medical_id: this.medical.reference,
					name: this.form.name,
				})
				.then( function(response) {
					component.showData();
					component.form = {};
				})
				.catch( function(error) {
				// BACK-END VALIDATION FALL-BACK
					if(error.response.data.errors){
						component.feedback.name.style = 'is-invalid';
						component.feedback.name.message = error.response.data.errors.name[0];
					}
				// SERVER ECOUNTER AN ERROR
					else{
						component.alert.fail.state = true;
						component.alert.fail.msg = 'This skin product could not be added.';
						component.view.show = false;// remove card content
						}
					console.log('Error: SkinProductsBox.storeData' + error);
				});
			
		},
		destroyData: function( index , ref) {
			var component = (this);
			var deleted = this.skin_products.splice(index, 1); // remove deleted 
			component.calcUpdatedAt(true);
			axios.delete(this.route + '/' + ref)
				.then( function() {})
				.catch( function(error) {
				// SERVER ECOUNTER AN ERROR
					component.alert.fail.state = true;
					component.alert.fail.msg = 'The skin product could not be removed.';	
					component.view.show = false;// remove card content
					console.log('Error: SkinProductsBox.destroyData' + error);
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
		this.indexData(this.info.skinProducts);
		this.medical.reference = this.info.medical.id;
		this.medical.hasRecord = this.info.medical.complete;	  
	}   
}
</script>
