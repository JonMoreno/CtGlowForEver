 <template>
 
 <div class="mx-auto col-12 col-sm-12 col-md-12 col-lg-6 my-4">
	  
	<!-- Alert Loading: -->
	<alert-loading :state="alert.load"> </alert-loading>
	
	<!-- Alert Error: -->
	<alert-error :state="alert.error" > </alert-error>

	<div v-show="view.show"  class="mx-4 card bg-light">
		<!-- card-body -->
		<div class="card-body" >
			<h4 class="card-title text-primary">
				<i class="fa fa-plus-square-o" aria-hidden="true"></i>
				General:
			</h4>

			<form method="#" action="#" v-on:change="updateData($event.target.name)">
				<!-- form-row -->
				<div class="form-row pl-3 over-flow-250">
			
					<div class="form-group col-12">
						<label> 
							<i v-if="view.edit" class="fa fa-caret-right text-primary" aria-hidden="true"></i>
							Dermatologist:
						</label>
						<div class="form-check form-check-inline pb-2">
							<label v-bind:class="[ view.edit? 'font-weight-bold' : 'pl-0' ]" class="form-check-label">
								<input 	v-if="view.edit" v-model="medical.dermatologist" name="dermatologist" class="form-check-input" type="checkbox"> 
								{{ medical.dermatologist ? 'yes': 'no' }}
							</label>
						</div>
					</div>
					<div class="form-group col-12">
						<label> 
							<i v-if="view.edit" class="fa fa-caret-right text-primary" aria-hidden="true"></i>
							Glasses: 
						</label>
						<div class="form-check form-check-inline pb-2">
							<label v-bind:class="[ view.edit? 'font-weight-bold' : 'pl-0' ]" class="form-check-label">
								<input v-if="view.edit" v-model="medical.glasses" name="glasses" class="form-check-input" type="checkbox"> 
								{{ medical.glasses? 'yes' : 'no' }}
							</label>
						</div>
					</div>
					<div class="form-group col-12">
						<label>
							<i v-if="view.edit" class="fa fa-caret-right text-primary" aria-hidden="true"></i>
							Pregnant<span class="text-muted">(female)</span>: 
						</label>
						<div class="form-check form-check-inline pb-2">
							<label v-bind:class="[ view.edit? 'font-weight-bold': 'pl-0' ]" class="form-check-label">
								<input v-if="view.edit" v-model="medical.pregnant" name="pregnant" class="form-check-input" type="checkbox"> 
								{{ medical.pregnant? 'yes' : 'no' }}
							</label>
						</div>
					</div>
					<div class="form-group col-12">
						<label> 
							<i v-if="view.edit" class="fa fa-caret-right text-primary" aria-hidden="true"></i>
							Smoker:
						</label>
						<div class="form-check form-check-inline pb-2">
							<label v-bind:class="[ view.edit? 'font-weight-bold': 'pl-0' ]" class="form-check-label">
								<input v-if="view.edit" v-model="medical.smoke" name="smoke" class="form-check-input" type="checkbox"> 
								{{ medical.smoke? 'yes' : 'no' }}
							</label>
						</div>
					</div>
				</div> <!-- ../form-row -->
			</form>
		</div><!-- ../card-body -->
		
		<div class="card-footer clearfix py-1">
			<div class="float-left text-muted">
				Last updated {{ medical.updated_at }}
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



<script type="text/javascript">
//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
window._ = require('lodash');
import AlertLoading from '../alert/Loading.vue'; // ALERT LOADING COMPONENT
import AlertError from '../alert/Error.vue'; // ALERT ERROR COMPONENT


export default {
/*---------------------------------------------------------------
| COMPONENT: GeneralCard
|----------------------------------------------------------------
| This vue component will handle creating a new client medical 
| records also updating medical records for existing client.
|
*/

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
	components: {
		'alert-loading': AlertLoading,
		'alert-error' : AlertError,
	},

//------------------------------------------------------
// COMPONENT PROPS
//------------------------------------------------------
	props: {
		info: {
			type: Object,
			required: true
		}
	},

//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
	data: function() {
		return {
			route: '/api/medicals',
			medical: '',
			client: {
				reference: '',
			},
			createBtn: true,
			view: {
				show: false,
				edit: false,
			},
			alert: {
				load: false,
				error: false,
				success: false
			},
		}
	},

//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
	methods: {
	//--------------------------------------------------
	// ALERTS
	//--------------------------------------------------
		error: function(bool) {
			this.view.show = !bool;
			this.alert.load = bool;
		},
		loading: function(bool) {
			this.view.show = !bool;
			this.alert.load = bool;
		},
	//--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
		createData: function() {
			var vi = (this);
			axios.post(vi.route , {
				    // Params:
					'complete': true,
					'client_id': vi.client.reference,
				}).then( function(response) {
					vi.showData();
				}).catch( function(error) {
					vi.error(true)
					console.log('Error: GeneralBox.updateData' + error);

				});
		
		},
		updateData: function(field){
			var vi= (this);
			axios.patch(vi.route + '/' + vi.client.reference,{
					// Params:
					[field]: vi.medical[field],
				}).then( function(response) {
					vi.medical.updated_at = response.data;
				}).catch( function(error) {
					vi.error(true)
					console.log('Error: GeneralBox.updateData' + error);
				});
		
		},
		showData: function() {
			let vi = this;
			axios.get(vi.route + '/' + vi.client.reference)
				.then( function(response) {
					vi.loading(false);
					vi.medical = {}; vi.medical = response.data
					vi.broadCastOnMedicalCreated();
				}).catch( function(error) {
					vi.error(true)
					console.log('GeneralCard.showData:' + error.response);
					
				});

		},
	//--------------------------------------------------
	// INITIAL DATA RENDERING
	//--------------------------------------------------
		indexData: _.debounce( function(data) {
			try{
				this.medical = data; // assign data to record
						
			}catch(error){
				this.error(true);
				this.loading(false);
				console.log('Error: GeneralBox.indexData' + error);
					
			}
		}, 100 ),
	//--------------------------------------------------
	// EVENT HANDLING
	//--------------------------------------------------
		onCreateBtn: function() {
			let vi = this;
			Event.listen('onCreateBtn', function() {
				vi.loading(true);
				vi.medical = {};
				vi.createData();
			});
		},
		broadCastOnMedicalCreated: function() {
			let vi = this;
			Event.fire('onMedicalCreated',
				{
					reference: vi.medical.id,
					complete: vi.medical.complete
				}
			);

		},
	},

//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
	created: function(){
		this.onCreateBtn();
		this.indexData(this.info.medical);
		this.view.show = this.info.medical.complete;
		this.client.reference = this.info.client.reference;	

	} 
}	
</script>


























