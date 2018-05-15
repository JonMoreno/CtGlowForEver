<template>
<!-- after-notes-card -->
 <div class="card mb-4 border-light-secondary">
    <form 	
        method="POST" 
        action="#" 
        @keyup="validateInput($event.target.name)" 
        @change="validateInput($event.target.name)"
    >
        <!-- after-notes-card-body -->
        <div class="card-body">
            <!-- legend padding -->
            <div class="mt-2 px-2">
                <!-- consultation-details -->
                <legend class="text-primary h5" @click="show.view = !show.view"> 
                    <span class="cursor-pointer">
                        <i class="fa fa-edit fa-lg text-primary" aria-hidden="true"></i>
                            After Notes
                        <i class="fa fa-caret-down text-primary " aria-hidden="true"></i>
                    </span>
                    <hr class="mt-1"/>
                </legend>

                
               
                <transition name="fade">
                    <span v-if="show.view">
                        <!-- input padding -->
                        <div class="px-2" v-show="show.form">
                            <!-- form-group row -->
                            <div class="form-group form-row mt-1 pt-2">
                            <!-- Today's Date -->
                            <!-- col -->
                                <label class="col-12 col-form-label pt-3">
                                    <i class="fa fa-minus-square-o text-primary" aria-hidden="true"></i>
                                    Today's Date:
                                </label>
                                <div class="col-12 offset-sm-2 col-sm-8 offset-md-3 col-md-6">
                                    <input type="date" v-model="today" readonly class="form-control disabled bg-light text-center mt-1 ">
                                    <small class="text-primary pl-4"> read only<i class="fa fa-caret-up  pl-2"></i></small>
                                </div>
                            <!-- col -->
                            </div>

                            <hr/>
                            <!-- form-group row -->
                            <div class="form-group row py-3">
                            <!-- Notes -->
                            <!-- col -->
                                <label class="col-12">
                                    <i class="fa fa-minus-square-o text-primary" aria-hidden="true"></i>
                                    Follow Up Notes:
                                </label>
                            <!-- col -->
                                <div class="col-12">
                                    <textarea 
                                        rows="4"
                                        name="notes" 
                                        class="form-control"

                                        v-model="after_notes.notes"
                                        :style="feedback.style('notes', 'input')"
                                    ></textarea>
                                    <div v-text="feedback.feedback('notes')" 
                                        :style="feedback.style('notes', 'feedback')"
                                    ></div>
                                </div>
                            </div><!-- ../form-group row -->
                        </div><!-- ../input padding -->
                    </span>
                </transition>
            </div>
            <!-- ../legend padding -->

            <span v-if="show.view">
                <!-- alert-icon-success-form-->
                <transition name="fade">
                    <alert-icon-success :state="show.form_success" class="no-border">
                        <div>
                            <h4>Great!</h4>
                            <p class="lh-1">Your consultation
                                <br/>details have been saved!
                            </p>
                        </div>
                    </alert-icon-success>
                </transition><!-- ../alert-icon-success-form-->

                <!-- alert-icon-danger-form-->
                <transition name="fade">
                    <alert-icon-fail :state="show.form_failed" class="no-border"></alert-icon-fail>
                </transition><!-- ../alert-icon-success-form-->
            </span>

        </div><!-- ../after-notes-card-body -->
    </form>
</div><!-- ../after-notes-card --> 
</template>
  

//COMPONENT   
<script type="text/javascript">

//dependencies.
window._ = require('lodash');
const moment = require('moment');
import Feedback from '../../utilities/feedback_v2.js';
import TodaysDate from '../../../helpers/todays_date';
import Validation from '../../utilities/validation.js';
import CreateRules from '../forms/create_rules.js';

import AlertIconFail from '../../alert/icon/fail.vue';
import AlertIconSuccess from '../../alert/icon/success.vue';



export default {
	components: {
		'alert-icon-fail': AlertIconFail,
        'alert-icon-success': AlertIconSuccess,

    },
    props: {
        reference: {
            default: '',
            type: [String,Number],
            required: true,
            
        }
    },

	data: function() {
        return {
            client_id: '',
            today: moment().format('YYYY-MM-DD'), 
            route: '/api/consultations',       
			after_notes: {
                notes: '',
            },
            show: {
                view: false,
                form: true,
                form_failed: false,
                form_success: false,
            },
			form: new Validation(),
			formData: new FormData(),
            feedback: new Feedback(),
        }
	},
	methods: {
    //http request.
		storeAfterNote: function(formData) {
			let vi = (this);
			axios.post(vi.route, formData)
				.then( function(response) {
                    vi.show.view = true;
					vi.show.form = false;
					vi.show.form_success = true;
                    vi.broadCastOnAfterNote(response.data);
                    setTimeout(function() {
                        vi.resetComponent();
                        vi.show.form = true;
                        vi.show.form_success = false;
                    }, 4000);
				})
				.catch( function(error){
                    Event.fire('onAfterNoteError');
                    $('.modal').animate({scrollTop: 0});
                    vi.show.view = true;
                    console.log('AfterNote.storeAfterNote() Error' + error);
					if(error.response.data.errors) {

						let errors = error.response.data.errors;
						for(let prop in errors){
							vi.feedback.setStyle(prop , 'input', 'invalid');
							vi.feedback.setStyle(prop , 'feedback', 'invalid');
							vi.feedback.setFeedBack(prop , errors[prop][0]);
						}
					}else{
						vi.show.form = false,
						vi.show.form_failed= true;
                    }
				});
		},
	//form.
		isValid: function(field) {
			let feedback = (this.feedback); 
			feedback.setStyle(field, 'input', 'valid'); 
            feedback.setStyle(field, 'feedback', 'valid');
            
			if(this.after_notes[field].length > 0){
                this.feedback.setFeedBack(field, 'looks great!');
            }else{
                this.feedback.setFeedBack(field, '');
            }
			return true;
		},
		isInValid: function(field) {
			let feedback = (this.feedback); let form = (this.form);
			feedback.setStyle(field, 'input', 'invalid');
			feedback.setStyle(field, 'feedback', 'invalid');
			feedback.setFeedBack(field, form.getMessage(field));
			return false;
			
		},
		validateForm: function() {
			let vi = this;
			let ready = true; 
			let form = Object.keys(this.after_notes);

			for(let field in form) {
				if(!vi.validateInput([form[field]]) ) {
                    $('.modal').animate({scrollTop: 0});
                     Event.fire('onAfterNoteError');
                    vi.show.view = true;
                    ready = false 
                }
			}
			return ready;
		},
		formAble: function() {
			let vi = this; let fields = Object.keys(this.after_notes);
			if(vi.validateForm()) {
				for(let input in fields) {
					if(vi.after_notes[fields[input]].length > 0) {
						vi.formData.append([fields[input]], vi.after_notes[fields[input]]);
					}
				}
				vi.formData.append('client_id', vi.reference);
				vi.storeAfterNote(vi.formData);
			}
		},
		validateInput: function(field) {
            let vi = this;
			if(vi.form.validate(field, vi.after_notes[field])) {
				return vi.isValid(field);
			}
			return vi.isInValid(field);

		},
	//init form.
		initForm: function() {
			let vi = this;
			let feedback = this.feedback;
			let fields = Object.keys(CreateRules); 
			for(let field in fields) {
				vi.$set(feedback.styleFeedBacks, [fields[field]], '');
				vi.$set(feedback.styleInputs, [fields[field]], '');
				vi.$set(feedback.messages, [fields[field]], '');
			}
			vi.form.setRules(CreateRules);
			
        },
    //events.
        listenOnStoreAfterNote: function() {
            let vi = this;
            Event.listen('onStoreAfterNote', function() {
                vi.formAble();
            });

        },
        broadCastOnAfterNote: function(after_notes) {
            Event.fire('onAfterNote', after_notes);

        },
   //component settings.
        resetComponent () {
            Object.assign(this.$data, this.$options.data());
            this.initForm();
            
        },
        listenOnResetComponent: function() {
            let vi = this;
            Event.listen('onResetComponent', function() {
                vi.resetComponent();
            });
        },
    },
    
    created: function() {
        this.initForm();
        this.listenOnResetComponent();
        this.listenOnStoreAfterNote();

    },

    mounted: function() {
        
    }
}
</script>
  

<style scoped>
	.input-group-btn:not(:first-child):not(:last-child) > .btn {
	    border-radius: 0;
	}
	.no-border {
		border: none !important;
	}
	.pay-border {
		border: 1px outset silver !important;
	}
</style>
