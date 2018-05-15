// TEMPLATE
<template>
	<div>
		<!-- consultaion-modal -->
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<!-- consultaion-modal-dialog -->
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<!-- consultaion-modal-content -->
				<div class="modal-content">
					<!-- consultaion-modal-header -->
					<div class="modal-header">
						<!-- consultaion-modal-title-->
						<h5 class="modal-title ls-1">
							<i class="fa fa-sticky-note fa-lg text-primary"></i> 
							Consultation
						</h5>
						<!-- consultaion-close-modal-button -->
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div><!-- ../consultaion-modal-header -->
					<!-- consultaion-modal-body -->
					<div class="modal-body pt-1 pb-5">

					<!-- Create Consultation After Note & Invoice -->
						<div v-if="views.consultation">
							<!-- client-credential -->
							<credentials :reference="client"></credentials><!-- ../client-credential -->
		
							<after-notes-form :reference="client.id"> </after-notes-form>

							<invoice-cashier :reference="client.id"> </invoice-cashier>
						</div>

					<!-- Create Consultation Calendar Event -->
						<transition name="bounce">
							<div v-if="views.consultEvent" :class="{'px-5' : views.consultEvent }" class="d-flex  flex-column justify-content-center">

								<h4 class="text-center my-3"> Schedule <span class="gfe-text-lred">next</span> consultation appointment?</h4>
							<!-- Not Not Button -->
								<button  
									type="button" 
									@click="onCreateConsultEvent(false)"
									class="btn btn-warning btn-block font-weight-bold my-3 text-center ls-1">
									<i class="fa fa-ban text-danger fa-lg" aria-hidden="true"></i>
									Not Right Now!
								</button>
									<br/>
							<!-- Create Consult Event -->
								<button 
								 	type="button" 
									@click="onCreateConsultEvent(true)"
									class="btn btn-dark btn-block font-weight-bold  my-3 text-center ls-1">
									<i class="fa fa-calendar text-light-primary" aria-hidden="true"></i>
									Take me there
								</button>
							</div>
						</transition>
					
					</div><!--../consultaion-modal-body -->
					
					<!-- consultaion-modal-footer -->
					<div v-if="!views.consultEvent" class="modal-footer py-4 bordert-light-secondary no-border" style="min-height: 100px !important;">
					</div> 
					<!--../consultaion-modal-footer -->

				</div><!-- ../consultaion-modal-content -->
			</div><!-- ../consultaion-modal-dialog -->
		</div><!-- ../consultaion-modal -->
	</div>
</template>  


// COMPONENT
<script type="text/javascript">

//dependencies.
import Credentials from './Credentials.vue';
import AfterNotesForm from './AfterNotes.vue';
import InvoiceCashier from './InvoiceCashier.vue';


export default {

	components: {
		'credentials': Credentials,
		'invoice-cashier': InvoiceCashier,
		'after-notes-form': AfterNotesForm,
		
	},

    data: function() {
		return {
			client: '',
			views: {
				consultation: true,
				consultEvent: false 
			}
		}
	},

    methods: {
		onCreateConsultEvent: function(bool){
			if(bool){
				window.location.href = "/master-calendar/";
			}else{
				$("#exampleModalCenter").modal('hide');
				window.location.reload(true);
			}
		},
		listenOnConsultEventCreate: function(){
			const vi = this;
			Event.listen('onConsultEventCreate', function(){
				vi.views.consultation = false;
				vi.views.consultEvent = true;
			});

		},
		listentOnConsultationModal: function(){
			let vi = this;
			Event.listen('onConsultationModal', function(client) {
				if(vi.client != client){
					vi.broadCastOnResetComponent();
				}
				vi.client = client;
			});
		},
		broadCastOnResetComponent: function() {
			let vi = this;
			Event.fire('onResetComponent');
		},
		resetComponent () {
            Object.assign(this.$data, this.$options.data());
            
        },
	},

    created: function() {
		this.listentOnConsultationModal();
		this.listenOnConsultEventCreate();
	}
}
</script>


// CLIENT STYILING
<style scoped>
	.no-border {
		border: none !important;
	}
</style>