<template>
    <div >
        <transition name="fade">
            <div v-if="display" class="pt-3 pb-0 px-3">
            <!-- alert-fail-icon -->
                <transition name="bounce">
                    <alert-icon-fail :state="show.alert_fail"> </alert-icon-fail>
                </transition>
            <!-- after-note-form -->
                <form 	
                    method="POST" 
                    action="#" 

                    v-on:click="applyCaret($event.target.name)"
                    v-on:keyup="validateInput($event.target.name)" 
                    v-on:change="validateInput($event.target.name)" 
                >
                <!-- after notes -->
                    <transition name="fade">
                    <!-- form-row -->
                        <div v-if="show.view" class="form-row">
                        <!-- created date -->
                            <div class="col-12 col-lg-6 mt-3">
                                <label class="font-weight-bold">
                                    <i class="fa fa-plus-square-o gfe-text-red"></i>
                                    Created Date:
                                </label>
                                <span class="pl-2"> {{ record.created_at }} </span>
                            <!-- input -->
                                <transition 
                                    name="custom-classes-transition"
                                    enter-active-class="animated zoomIn"
                                    leave-active-class="animated zoomOut">
                                    <input 
                                        name="created_at"
                                        type="text" 
                                        readonly class="form-control bg-light"

                                        v-if="show.edit" 
                                        :value="record.created_at"
                                    >
                                </transition>
                            <!-- feedback -->
                                <div v-if="show.edit" class="">
                                    <small class="text-primary"> read only<i class="fa fa-caret-up  pl-2"></i></small>
                                </div>
                            </div>
                        
                        <!-- Notes -->
                            <div class="col-12 my-4">
                                <label class="font-weight-bold mb-0">
                                    <i v-if="editing.notes" class="fa fa-spinner fa-pulse fa-lg text-primary"></i>
                                    <i v-else class="fa fa-plus-square-o  gfe-text-red"></i>
                                    Follow Up Notes:
                                </label>
                                <span class="d-block px-5 pb-3">{{ record.notes }}
                                    <span v-show="editing.notes">
                                        <i aria-hidden="true" class="fa fa-caret-left fa-lg text-primary"></i>
                                        <hr class="my-0"/>
                                    </span>
                                </span>
                            <!-- input -->
                                <transition 
                                    name="custom-classes-transition"
                                    enter-active-class="animated zoomIn"
                                    leave-active-class="animated zoomOut">
                                    <div v-if="show.edit">
                                        <textarea 
                                            rows="4"
                                            name="notes" 
                                            class="form-control bg-light"

                                            v-model="record.notes"
                                            :style="feedback.style('notes', 'input')"
                                        ></textarea>
                                    <!-- feedback -->
                                        <div class="text-center" v-text="feedback.feedback('notes')" 
                                            :style="feedback.style('notes', 'feedback')"
                                        ></div>
                                    </div>
                                </transition>
                            </div><!-- ../Notes -->
                        </div><!--../form-row-->
                    </transition>  
                </form>
                <div class="clearfix">
                <!-- last updated -->
                    <p class="text-muted pull-left pl-3">
                        Last updated {{ record.updated_at }}
                    </p>
                <!-- edit button -->
                    <div class="pull-right">
                        <button 
                            @click="show.edit = !show.edit"
                            type="button" class="btn btn-link">
                            <span v-if="show.edit">Editing...</span>
                            <span v-else>Edit</span>
                        </button> 
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script type="text/javascript">

let timeout = null;

//dependencies.
import Feedback from '../../utilities/feedback_v2.js';
import TodaysDate from '../../../helpers/todays_date';
import Validation from '../../utilities/validation.js';
import EditRules from '../forms/edit_rules.js';

import AlertIconFail from '../../alert/icon/fail.vue';
import AlertIconSuccess from '../../alert/icon/success.vue';

export default {
    components: {
        'alert-icon-fail': AlertIconFail
    },

    props: {
        record: {
            type: [Object],
            required: true
        },
        display: {
            type: Boolean,
            required: true
        }
    },

    data: function() {
        return {
            show: {
                view: false,
                edit: false,
                alert_fail: false
            },
            editing: {
                created_at: false,
                notes: false,
            },
            isActive: true,
            form: new FormData(),
            feedback: new Feedback(),
            validation: new Validation(),
            route: '/api/consultations/',
        }
    },


    methods:{
    // User interface.
        applyCaret: function(field){
			let property = Object.keys(this.editing);
			this.editing[field] = true;
			for(let name in property){
				if(property[name] !== field){
					this.editing[property[name]] = false;
				}	
			}			
		},
    //validation.
        isValid: function(field) {
			let feedback = (this.feedback); 
			feedback.setStyle(field, 'input', 'valid'); 
			feedback.setStyle(field, 'feedback', 'valid');
			feedback.setFeedBack(field, 'looks great!');
			return true;
		},
		isInValid: function(field) {
			let feedback = (this.feedback); let form = (this.validation);
			feedback.setStyle(field, 'input', 'invalid');
			feedback.setStyle(field, 'feedback', 'invalid');
			feedback.setFeedBack(field, form.getMessage(field));
			return false;
		},
        validateInput: function(field){
            let vi = this;
            vi.editing[field] = true;
            clearTimeout(timeout);
            timeout = setTimeout (function(){
                if(vi.validation.validate(field, vi.record[field])) {
                    vi.isValid(field);
                    vi.update(field);
                    vi.editing[field] = false;
                    return;
                }
                vi.editing[field] = false;
                return vi.isInValid(field);
            }, 600);
        }, 
    //http request.
        update: function(field) {
            let vi = this;
            axios.patch(vi.route + vi.record.id, {
                    [field]: vi.record[field],
                    client_id: vi.record.client_id
                }).then( function(response) { 
                    vi.record.updated_at = response.data;
                    
                }).catch( function(error) {
                    console.log('Error: AfterNotedTab.update()');
                    if(error.response.data.errors){ 	// back-end validation failed
                        let errors = error.response.data.errors;
						for(let prop in errors){
							vi.feedback.setStyle(prop , 'input', 'invalid');
							vi.feedback.setStyle(prop , 'feedback', 'invalid');
							vi.feedback.setFeedBack(prop , errors[prop][0]);

						}
					}else{								// server encounter an error
						vi.show.view = false;
                            setTimeout( function() {
                                vi.show.alert_fail = true;
                            },500);
					}
                });

        }, 
    //init config. 
        initFormFields: function() {
            //init form.
            let vi = this;
            let feedback = this.feedback;
            let fields = Object.keys(EditRules); 
            for(let field in fields) {
                vi.$set(feedback.styleFeedBacks, [fields[field]], '');
                vi.$set(feedback.styleInputs, [fields[field]], '');
                vi.$set(feedback.messages, [fields[field]], '');
            }
            vi.validation.setRules(EditRules);
        }
    },

    created: function() {
        this.initFormFields();
    },

    mounted: function() {
        let vi = this;
        setTimeout( function() {
            vi.show.view = true; 
        }, 500);//toggle fade in.

    }

}

</script>