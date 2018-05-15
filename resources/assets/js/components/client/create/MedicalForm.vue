
<template>
    <div>
    <!-- FORM DIVIDER -->
        <div class="divider mb-0"></div>
        <p class="text-muted text-center ls-1 font-weight-bold"> medical information </p>
        <form 
            v-if="views.form"
            @click="validateFormField($event.target.name)" 
            @keyup="validateFormField($event.target.name)" 
            @change="validateFormField($event.target.name)"> 
        
        <!-- ANOTHER DEMATOLOGIST -->
            <div class="row my-5">
                <div class="form-group col-7">
                    <div class="form-row">
                        <label class="col-12 col-form-label-lg">
                            <span v-if="views.lang.english">
                               ARE YOU UNDER THE CARE OF A DERMATOLOGIST?
                            </span>
                            <span v-else>
                                ¿ESTÁS BAJO EL CUIDADO DE UN DERMATÓLOGO?
                            </span>
                        </label>
                        <div class="col-12 pl-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.dermatologist" name="dermatologist" class="form-check-input big-checkbox" type="radio" value="1">
                                <label class="form-check-label">
                                    <span v-if="views.lang.english">yes</span>
                                    <span v-else>si </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="form.dermatologist" name="dermatologist" class="form-check-input big-checkbox" type="radio" value="0">
                                <label class="form-check-label" for="inlineCheckbox2">no</label>
                            </div>
                        </div>
                        <div v-text="feedback.feedback('dermatologist')" :style="feedback.style('dermatologist', 'feedback')" class="f-100"></div>
                    </div>
                </div>
        <!-- CURRENTLY PREGNANT -->
                <div class="form-group col-5">
                    <div class="form-row">
                        <label class="col-12 col-form-label-lg">
                            <span v-if="views.lang.english">ARE YOU CURRENTLY PREGNANT?<small>(female)</small> </span>
                            <span v-else>¿ESTA EMBARAZADA ACTUALMENTE?<small>(mujeres)</small></span>
                        </label>
                        <div class="col-12 pl-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.pregnant" name="pregnant" class="form-check-input big-checkbox" type="radio" value="1">
                                <label class="form-check-label">
                                    <span v-if="views.lang.english">yes</span>
                                    <span v-else>si </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="form.pregnant" name="pregnant" class="form-check-input big-checkbox" type="radio" value="0">
                                <label class="form-check-label">no</label>
                            </div>
                        </div>
                        <div v-text="feedback.feedback('pregnant')" :style="feedback.style('pregnant', 'feedback')" class="f-100"></div>
                    </div>
                </div>
            </div>
        
        <!-- DO YOU USE GLASSES -->
            <div class="row my-5">
                <div class="form-group col-7">
                    <div class="form-row">
                        <label class="col-form-label-lg col-12">
                            <span v-if="views.lang.english">DO YOU USE GLASSES?</span>
                            <span v-else> USAS LENTES DE PRESCRIPCION? </span>
                        </label>
                        <div class="col-12 pl-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.glasses" name="glasses" class="form-check-input big-checkbox" type="radio" value="1">
                                <label class="form-check-label">
                                    <span v-if="views.lang.english">yes</span>
                                    <span v-else>si </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="form.glasses" name="glasses" class="form-check-input big-checkbox" type="radio" value="0">
                                <label class="form-check-label">no</label>
                            </div>
                        </div>
                        <div v-text="feedback.feedback('glasses')" :style="feedback.style('pregnant', 'feedback')" class="f-100"></div>
                    </div>
                </div>
        <!-- DO YOU SMOKE -->
                <div class="form-group col-5">
                    <div class="form-row">
                        <label class="col-form-label-lg col-12"> 
                           <span v-if="views.lang.english">DO YOU SMOKE?</span>
                            <span v-else>¿FUMAS? </span>
                        </label>
                        <div class="col-12 pl-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.smoke" name="smoke" class="form-check-input big-checkbox" type="radio" value="1">
                                <label class="form-check-label">
                                    <span v-if="views.lang.english">yes</span>
                                    <span v-else>si </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input v-model="form.smoke" name="smoke" class="form-check-input big-checkbox" type="radio" value="0">
                                <label class="form-check-label">no</label>
                            </div>
                        </div>
                        <div v-text="feedback.feedback('smoke')" :style="feedback.style('smoke', 'feedback')" class="f-100"></div>
                    </div>
                </div>
            </div>
        
        </form>
    </div>
</template>


<script>

import Moment from 'moment';
import States from '../../utilities/usa_states.js';
import FeedBack from "../../utilities/feedback_v2.js";
import Validation from "../../utilities/validation.js";
import FormRules from '../../rules/client_create_medicalform.js';

export default {

    data: function(){
        return {
            route: '/api/medicals',
            clientRef: false,
            views:{
                lang: {
                    english: true,
                    spanish: false,
                },
                form: true,
                alertFail: false
            },
            form:{
                smoke: '',
                glasses: '',
                pregnant: '',
                dermatologist: '',
            },
            feedback: new FeedBack(),
            formData: new FormData(),
            validation: new Validation(),
        }
    },

    methods:{ 
        storeClientMedical: function(){
            const vi = this;  
            vi.formData.append('complete', 1); 
            vi.formData.append('client_id', vi.clientRef);          
            axios.post(vi.route, vi.formData)
                .then( function(response){
                    vi.broadCastOnSubmitSuccess(response.data);
                })
                .catch( function(error){
                    if(error.response.data.errors) {
                        let errors = error.response.data.errors;
                        for(let prop in errors){
                            vi.feedback.setStyle(prop , 'input', 'invalid');
                            vi.feedback.setStyle(prop , 'feedback', 'invalid');
                            vi.feedback.setFeedBack(prop , errors[prop][0]);
                        }
                        vi.broadCastOnSubmitIncomplete();
                    }else{
                        vi.broadCastOnSubmitError();
                        console.log("MedicalForm.storeClientMedical(); Error: " + error);
                    }
                });
        },
        validateAndSubmitForm: function(){
            if(this.validateCompleteForm()){
                this.broadCastOnValidationPass();
            }
        },
        prepFormData: function(){
            const vi = this;
            for(let field in vi.form){ //append all form values.
                vi.formData.append(field, vi.form[field]);
            }
        },
        validateCompleteForm: function(){
            let status = true;
            const vi = this;
            for(let field in vi.form){
                if(!vi.validateField(field)){
                    status = false
                }
            }
            return status;
        },
        validateField: function(input){ // No _.debounce() for rapid looping.
            const vi = this;
            if(!this.validation.validate(input, vi.form[input])){
                return this.isInvalid(input);
            }else{
                return this.clearField(input);
            }
        },
        validateFormField: _.debounce(function(input){            
            if(!this.validation.validate(input, this.form[input])){
                this.isInvalid(input);
            }else{
                this.clearField(input);
            }
        }, 400),
        isInvalid: function(field) {
			this.feedback.setStyle(field, 'input', 'invalid');
			this.feedback.setStyle(field, 'feedback', 'invalid');
			this.feedback.setFeedBack(field, this.validation.getMessage(field));
			return false;
        },
        clearField: function(field) {
			this.feedback.setStyle(field, 'input', 'clear');
			this.feedback.setStyle(field, 'feedback', 'clear');
			this.feedback.setFeedBack(field, '');
			return true;
        },
        initForm: function(){
            const vi = this;
            for(let field in FormRules){
                vi.$set(vi.feedback.styleFeedBacks, [field], '');
                vi.$set(vi.feedback.styleInputs, [field], '');
                vi.$set(vi.feedback.messages, [field], '');
            }
            vi.validation.setRules(FormRules);
        },
        broadCastOnValidationPass: function(){
            Event.fire('OnValidationPassMedicalForm', {form: 'medical', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
            Event.listen('OnStoreMedicalForm', function(response){
                vi.clientRef = response;
                if(vi.clientRef !== false && vi.clientRef != null){
                    if(vi.validateCompleteForm()){
                        vi.prepFormData();
                        vi.storeClientMedical();
                    }
                }
            });
        },
        broadCastOnSubmitIncomplete: function(){
            Event.fire('OnSubmitIncompleteMedicalForm');
        },
        broadCastOnSubmitSuccess: function(response){
            Event.fire('OnSubmitSuccessMedicalForm', response);
        },
        broadCastOnSubmitError: function(){
            Event.fire('OnSubmitErrorMedicalForm');
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitMedicalForm', function(){
                if(!vi.validateCompleteForm()){
                    vi.broadCastOnSubmitIncomplete();
                }else{
                    vi.validateAndSubmitForm();
                }
            });
        },
        listenOnLanguageChange: function(){
            const vi = this;
            Event.listen('OnLanguageChange', function(selection){
                vi.toggleLanguage(selection);
            }); 
        },
        toggleLanguage: function(pick){
            for(let lang in this.views.lang){
                if(lang == pick){
                    this.views.lang[pick] = true;
                    this.validation.setLanguge(pick);
                }else{
                    this.views.lang[lang] = false;
                }
            }
        },
    },

    mounted: function(){
        this.initForm();
        this.listenOnSubmit();
        this.listenOnStoreForm();
        this.listenOnLanguageChange();
    }
}
</script>


<style scoped>
    .big-checkbox {
        width: 25px; height: 25px;
    }  
    .f-100{
        font-size:  100% !important;
    } 
</style>



