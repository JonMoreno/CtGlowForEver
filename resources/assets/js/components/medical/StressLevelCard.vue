// COMPONENT TEMPLATE
<template>

<div v-show="medical.hasRecord" class="mx-auto col-12 col-sm-12 col-md-12 col-lg-6 mx-auto my-4">
	<!-- Alert Loading: -->
	<alert-loading :state="alert.load"> </alert-loading>

	<!-- Alert Error: -->
	<alert-error :state="alert.error"> </alert-error>

	<div class="card bg-light mx-4">   
		<div class="card-header bg-white">
			<h5 class="lead text-center ls-1">overall-stress-level</h5>
				<div class="progress">
					<div 
						:aria-valuenow="stressAverage()"
						:style="stressAverageStyle()"
						
						class="progress-bar progress-bar-striped progress-bar-animated height-15" role="progressbar" aria-valuemin="1" aria-valuemax="10" 
					>
						<span class="align-middle">{{stressAverage()}}</span>
					</div>
				</div>
		</div>
		<div class="card-body pb-0">
			<h4 class="card-title text-primary">
				<i class="fa fa-plus-square-o" aria-hidden="true"></i>
				Stress Levels:
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
				
			<!-- form-row -->
			<div v-show="view.show" class="form-row pl-3">
				<transition name="bounce">
					<div  v-show="view.edit" class="col-12">
						<table class="table table-sm list-group-flush mb-0">
						<!-- ENTER NEW RECORD -->
							<tr class="">  
								<td class="py-0">
									<div><small class="text-primary"> Today's date<i class="fa fa-caret-down  pl-2"></i></small></div>
									<input type="date"  class="form-control bg-white text-center form-control-sm disabled" v-model="form.today" readonly>
									
								</td>
							<!-- ENTER RECORD -->
								<td class="py-0"> 
									<form   metod="POST" action="#"
											@click="validateInput($event.target.name)">
										<div class="form-group">
											<div class="text-center text-primary py-0">Level: {{form.stress_level}}</div>
											<input  
												min="0"
												max="10"
												type="range" 
												name="stress_level"
												class="form-control" 
												placeholder="Number between 1-10"

												v-model="form.stress_level"
												:style="feedback.style('stress_level', 'input')"
											>
											<div v-text="feedback.feedback('stress_level')"
												:style="feedback.style('stress_level', 'feedback')"
											></div>
										</div>
									</form>
								</td>
							<!-- SAVE RECORD -->
								<td class="align-middle pt-3">
									<a  v-on:click.stop.prevent="storeData()" :class="{disabled : btnDisable}" class="btn btn-primary btn-sm ls-1" href="#">
										<i class="fa fa-floppy-o fa-lg"></i>
										Save
									</a>
								</td>
							</tr>
						</table>
					</div>
				</transition>
				<div class="form-group col-12 over-flow-250">
					<table class="table table-sm table-hover mb-0">
						<thead>
							<tr>
								<th>Recorded Date:</th>
								<th>Stress Level:</th>
								<th v-show="view.edit === true" >&nbsp;</th>
							</tr>
						</thead>
							<transition-group name="list" tag="tbody">
							<!-- EXISTING RECORDS -->
								<tr v-for="(stress_level, index) in stress_levels" :key="stress_level.id">
									<td class="align-middle py-1">{{ stress_level.created_at }}</td>
									<td class="align-middle py-1">
										<div class="progress">
											<div class="progress-bar" role="progressbar" :style="stressBarStyling(stress_level.stress_level)" :aria-valuenow="stress_level.stress_level" aria-valuemin="1" aria-valuemax="10">
												{{stress_level.stress_level}}
											</div>
										</div>
									</td>
									<td v-if="view.edit" class="py-1">
										<a v-on:click.stop.prevent="destroyData( index , stress_level.id)" class="btn btn-danger btn-sm py-1" href="#">
											<i class="fa fa-trash-o fa-lg"></i> 
											Delete
										</a>
									</td>
								</tr>  
							</transition-group>                      
					</table>
				<!-- EMPTY LIST -->
					<div class="list-group">
						<a v-if="stress_levels.length == 0"
							class="list-group-item list-group-item-action text-center px-2">
							<p class="lead">
								<i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>No stress levels recorded.
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

let timeout = null;
//------------------------------------------------------
// COMPONENT DEPENDENCIES
//------------------------------------------------------ 
window._ = require('lodash');
import Moment from 'moment';
import AlertLoading from '../alert/Loading.vue';
import AlertError from '../alert/Error.vue';
import AlertFail from '../alert/Fail.vue';

import FeedBack from "../utilities/feedback_v2.js";
import TodaysDate from '../../helpers/todays_date.js';


export default {
/*---------------------------------------------------------------
| COMPONENT: MedicationCard
|----------------------------------------------------------------
| This vue component will handle adding stress level to 
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
			route: '/api/stress-levels',
			stress_levels: [],
			medical: {
				reference: '',
				hasRecord: false
			},
			form: {
				id: '',
				medical_id: '',
                stress_level: '',
                today:  Moment().format('YYYY-MM-DD'),
            },
			feedback: new FeedBack(),
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
			btnDisable: true,

			average: '',
			updated_at: ''
	    }
	}, 

//------------------------------------------------------
// INSTANCE METHODS
//------------------------------------------------------  
	methods: {
	//--------------------------------------------------
	// PROGRESS BAR STYLING AND COMPUTATIONS.
    //-------------------------------------------------- 
		stressAverage: function() {
			let total = 0;
			let average = 0;
			let levels = this.stress_levels;
			let size = this.stress_levels.length;
			for(let i = 0; i < size; i++){
				total = total + levels[i].stress_level;
				if(i == (size - 1)){
					average = (total / size);
				}
			}
			this.average = average.toFixed(1);
			return this.average;

		},
		stressAverageStyle: function() {
			let vi = this;
			if(vi.average){
				return vi.stressBarStyling(Math.round(vi.average));
			}
		},
		stressBarStyling: function(level) {
			let percentage = level + '0%';

			let success = '#28a745';
			let primary = '#007bff';
			let warning = '#ffc107';
			let danger = '#dc3545';

			let color;

			if(level < 3){ color = success; }
			else if(level >= 3 && level < 5){ color = primary; }
			else if(level >= 5 && level < 8) { color = warning; }
			else if(level >= 8 && level <= 10){ color = danger; }
			
			return {
				width: [percentage],
				backgroundColor: [color],
			};

		},
	//--------------------------------------------------
	// FORM VALIDATION & METHODS
    //--------------------------------------------------  
        validateInput: function(field) {
            let vi = this;
            clearTimeout(timeout);
            timeout = setTimeout( function() {
                if(vi.validate(field)){
                    vi.isValid(field);
                }else{
                    vi.isInValid(field);
                }
            }, 500);
        },
        validate: function(field) {
            let vi = this;
            if(vi.form[field] <= 10 && vi.form[field] > 0){
				return true;
			}else{
				return false;
			}
        },
        isInValid: function(field) {
            let feedback = this.feedback;
            this.btnDisable = true;
            feedback.setStyle(field, 'input', 'invalid');
            feedback.setStyle(field, 'feedback', 'invalid');
            feedback.setFeedBack(field, '');
        },
        isValid: function(field) {
            let feedback = this.feedback;
            this.btnDisable = false;
            feedback.setStyle(field, 'input', 'valid');
            feedback.setStyle(field, 'feedback', 'valid');
			feedback.setFeedBack(field, '');
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
				this.stress_levels = temp;
				this.view.show = true; 
				this.stress_levels.length >= 1 ? this.calcUpdatedAt() : '';
			}catch(error){
				// CRITICAL ERROR
				this.alert.load = false; 
				this.view.show = false; 
				this.alert.error = true; 
				console.log('Error: StressLevelCard.indexData' + error);
			}
				
		}, 300 ),
		calcUpdatedAt: function(now = false){
			if(now){
				this.updated_at = '1 second ago';
			}else{
				this.updated_at = this.stress_levels[0].updated_at;
			}
		},
	//--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
		showData: function() {
			var vi = (this);
			axios.get(this.route + '/' + this.medical.reference)
				.then( function(response) {
					//vi.stress_levels = [];
					vi.indexData(response.data); 
				})
				.catch( function(error) { // Server encounter an error.
					console.log('Error: StressLevelCard..showData' + error); 
					vi.alert.fail.state = true;
					vi.alert.fail.msg = 'The stress level list could not be refreshed.';
					vi.view.show = false;// remove card content
				});

		
		},
		storeData: function() {
			var vi = (this);
			vi.btnDisable = true;

			axios.post( this.route, { // Make axios request.
					medical_id: this.medical.reference,
					stress_level: this.form.stress_level,
				})
				.then( function(response) {
					vi.showData();
					vi.form.stress_level = null;
				})
				.catch( function(error) {
                    // BACK-END VALIDATION FALL-BACK
                    if(error.response.data.errors){ 	// back-end validation failed
                        let errors = error.response.data.errors;
						for(let prop in errors){
							vi.feedback.setStyle(prop , 'input', 'invalid');
							vi.feedback.setStyle(prop , 'feedback', 'invalid');
							vi.feedback.setFeedBack(prop , errors[prop][0]);

						}
					}
					// SERVER ECOUNTER AN ERROR
					else{
						vi.alert.fail.state = true;
						vi.alert.fail.msg = 'This stress level record could not be added.';
						vi.view.show = false;// remove card content
					}
						console.log('Error: StressLevel.storeData' + error);
				
				});
			
		},
		destroyData: function( index , ref) {
			var vi = (this);
			var deleted = this.stress_levels.splice(index, 1); // remove deleted
			vi.calcUpdatedAt(true); // just now
			axios.delete(this.route + '/' + ref)
				.then( function() {})
				.catch( function(error) { 
				// SERVER ECOUNTER AN ERROR
					vi.alert.fail.state = true;
					vi.alert.fail.msg = 'This stress level record could not be removed.';	
					vi.view.show = false;// remove card content
					console.log('Error: StressLevel.destroyData' + error);
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
    // FEEDBACK INITIATION
        initFeedBack: function() {
            let vi = this;
            let feedback = this.feedback;
            vi.$set(feedback.styleFeedBacks, 'stress_level', '');
        }	   
	},

//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------   
	created: function () {
		this.onMedicalCreated();
		this.onCloseAlertFail();
		this.indexData(this.info.stressLevels);
		this.medical.reference = this.info.medical.id;
		this.medical.hasRecord = this.info.medical.complete;
	},
	mounted: function(){
	}
}
</script>

// COMPONENT STLING
<style  type="scoped">
	td {
		text-transform: capitalize;
	}
	.height-15 {
		height: 15px;
	}
	.height-15>span {
		font-size: 155%;
	}
</style>








