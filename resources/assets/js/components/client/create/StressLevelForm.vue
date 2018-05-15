
<template>
    <div>
        <form 
            v-if="views.form"
            @click="validateFormField($event.target.name)" 
            @keyup="validateFormField($event.target.name)" 
            @change="validateFormField($event.target.name)"> 
            <!-- STRESS LEVEL -->
                <div class="row my-5">
                    <div class="form-group col-12">
                        <div class="form-row">
                            <label class="col-12 col-form-label-lg">
                                <span v-if="views.lang.english">
                                    WHAT IS YOUR STRESS LEVEL NOW?
                                </span>
                                <span v-else>
                                    ¿CUÁL ES SU NIVEL DE ESTRÉS AHORA?
                                </span>
                            </label>
                            <div 
                                class="col-12 f-100 mt-0"
                                v-text="feedback.feedback('stress_level')"
                                :style="feedback.style('stress_level', 'feedback')"
                            ></div>
                        </div>
                        <div class="form-row pl-3">
                            <div class="col-12 pl-5">
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="1">
                                    <label class="form-check-labeltext-uppercase">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="2">
                                    <label class="form-check-labeltext-uppercase">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="3">
                                    <label class="form-check-labeltext-uppercase">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="4">
                                    <label class="form-check-labeltext-uppercase">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="5">
                                    <label class="form-check-labeltext-uppercase">5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="6">
                                    <label class="form-check-labeltext-uppercase">6</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="7">
                                    <label class="form-check-labeltext-uppercase">7</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="8">
                                    <label class="form-check-labeltext-uppercase">8</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="9">
                                    <label class="form-check-labeltext-uppercase">9</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input v-model="form.stress_level" name="stress_level" class="form-check-input big-checkbox" type="radio" value="10">
                                    <label class="form-check-labeltext-uppercase">10</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- ../STRESS LEVEL -->       
        </form>
    </div>
</template>


<script>

import Moment from 'moment';
import States from '../../utilities/usa_states.js';
import FeedBack from "../../utilities/feedback_v2.js";
import Validation from "../../utilities/validation.js";
import FormRules from '../../rules/client_create_stresslevelform.js';

export default {

    data: function(){
        return {
            route: '/api/stress-levels',
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
                stress_level: [],
            },
            feedback: new FeedBack(),
            formData: new FormData(),
            validation: new Validation(),
        }
    },

    methods:{ 
        storeClientStressLevel: function(){
            const vi = this;          
            axios.post(vi.route, vi.formData)
                .then( function(response){
                    vi.broadCastOnSubmitSuccess();
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
                        console.log("StressLevelForm.storeClientStressLevel(); Error: " + error);
                    }
                });
        },
        validateAndSubmitForm: function(){
            if(this.validateCompleteForm()){
                this.broadCastOnValidationPass();
            }else{
                this.broadCastOnSubmitIncomplete();
            }
        },
        prepFormData: function(){
            const vi = this;
            vi.formData.append('medical_id', vi.clientRef[0].reference);  

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
        }, 600),
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
            Event.fire('OnValidationPassStressLevelForm', {form: 'stress_level', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
            Event.listen('OnStoreStressLevelForm', function(response){
                vi.clientRef = response;
                if(vi.clientRef !== false && vi.clientRef != null){
                    if(vi.validateCompleteForm()){
                        vi.prepFormData();
                        vi.storeClientStressLevel();
                    }
                }
            });
        },
        broadCastOnSubmitIncomplete: function(){
            Event.fire('OnSubmitIncompleteStressLevelForm');
        },
        broadCastOnSubmitSuccess: function(){
            Event.fire('OnSubmitSuccessStressLevelForm');
        },
        broadCastOnSubmitError: function(){
            Event.fire('OnSubmitErrorStressLevelForm');
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitStressLevelForm', function(){
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



