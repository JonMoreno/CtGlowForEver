
<template>
    <div>
         <transition name="fade">
            <div v-if="views.alertFail" class="card card-body">
                <alert-fail :state="views.alertFail"></alert-fail>
            </div>
        </transition>

        <form 
            v-if="views.form"
            @click="validateFormField($event.target.name)" 
            @keyup="validateFormField($event.target.name)" 
            @change="validateFormField($event.target.name)"> 
        
        <!-- CURRENTLY TAKING ANY OF THESE MEDICATIONS -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <div class="form-row">
                        <label class="col-12 col-form-label-lg mb-0">
                            <span v-if="views.lang.english">
                                ARE YOU TAKING ANY OF THE FOLLOWING MEDICATIONS?
                            </span>
                            <span v-else>
                                ¿ESTÁ TOMANDO CUALQUIERA DE LOS SIGUIENTES MEDICAMENTOS?
                            </span>
                        </label>
                        <div 
                            class="col-12 f-100 text-center mt-0 mb-3"
                            v-text="feedback.feedback('medications')"
                            :style="feedback.style('medications', 'feedback')"
                        ></div>
                    </div>
                    <div class="form-row">
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="azlex">
                                <label class="form-check-label text-uppercase">Azlex</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="differin">
                                <label class="form-check-label text-uppercase">Differin</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="renova">
                                <label class="form-check-label text-uppercase">Renova</label>
                            </div>
                        </div>

                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="retin-a">
                                <label class="form-check-label text-uppercase">Retin-A</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="tazarac">
                                <label class="form-check-label text-uppercase">Tazarac</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="glycolic">
                                <label class="form-check-label text-uppercase">Glycolic</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline mr-0">
                                <input v-model="form.medications" name="medications" class="form-check-input big-checkbox" type="checkbox" value="alpha hydroxy acids">
                                <small class="form-check-label text-uppercase">Alpha Hydroxy Acids</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- ../CURRENTLY TAKING ANY OF THESE MEDICATIONS -->
        <!-- ALTERNATE MEDICATIONS -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg"> 
                        <span v-if="views.lang.english">
                            LIST ANY OTHER MEDICATIONS YOU ARE TAKING NOW:
                        </span>
                        <span v-else>
                            ENUMERE CUALQUIER OTRO MEDICAMENTO QUE ESTÁ TOMANDO:
                        </span>
                    </label>
                        <div 
                        class="f-100"
                        v-text="feedback.feedback('alt_medications')"
                        :style="feedback.style('alt_medications', 'feedback')"
                    ></div>
                    <input-list target-name="alt_medications" target-arrey="alt_medications"></input-list>
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
import InputList from '../../main/lists/InputList.vue';
import FormRules from '../../rules/client_create_medicationsform.js';

export default {

    components:{
        'input-list': InputList
    },

    data: function(){
        return {
            route: '/api/medications',
            clientRef: '',
            views:{
                lang: {
                    english: true,
                    spanish: false,
                },
                form: true,
                alertFail: false
            },
            form:{
                medications: [],
                alt_medications: [],
            },
            feedback: new FeedBack(),
            formData: new FormData(),
            validation: new Validation(),
        }
    },

    methods:{ 
        storeClientMedications: function(formData){
            const vi = this;          
            axios.post(vi.route, formData)
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
                        console.log("SkinProductsForm.storeClientMedications(); Error: " + error);
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
        loopFormData: function(){
            const vi = this;

            if(vi.form.medications.length != 0 && vi.form.alt_medications != 0){
                for(let index in vi.form.medications){
                    
                    vi.formData = null; vi.formData = new FormData();

                    vi.formData.append('medical_id',  vi.clientRef[0].reference);
                    vi.formData.append('name' , vi.form.medications[index]);
                    vi.formData.append('withdrawal_period' ,'');

                    vi.storeClientMedications(vi.formData);
                }

                for(let index in vi.form.alt_medications){
                    
                    vi.formData = null; vi.formData = new FormData();

                    vi.formData.append('medical_id',  vi.clientRef[0].reference);
                    vi.formData.append('name' , vi.form.alt_medications[index].value);
                    vi.formData.append('withdrawal_period' ,'');

                    vi.storeClientMedications(vi.formData);
                }
            }else{
                vi.broadCastOnSubmitSuccess();
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
        listenOnInputList: function(){
            const vi = this;
            Event.listen('OnInputList', function(input){
                if(vi.form.hasOwnProperty(input.targetArrey)){
                    vi.form[input.targetArrey] = input.data;
                }
            });
        },
        broadCastOnValidationPass: function(){
            Event.fire('OnValidationPassMedicationsForm', {form: 'medications', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
            Event.listen('OnStoreMedicationsForm', function(response){
                vi.clientRef = response;
                if(vi.clientRef !== false && vi.clientRef != null){
                    if(vi.validateCompleteForm()){
                        vi.loopFormData();
                    }
                }
            });
        },
        broadCastOnSubmitIncomplete: function(){
            Event.fire('OnSubmitIncompleteMedicationsForm');
        },
        broadCastOnSubmitSuccess: function(){
            Event.fire('OnSubmitSuccessMedicationsForm');
        },
        broadCastOnSubmitError: function(){
            Event.fire('OnSubmitErrorMedicationsForm');
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitMedicationsForm', function(){
                if(!vi.validateCompleteForm()){
                    vi.broadCastOnSubmitIncomplete();
                }
                else{
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
        this.listenOnInputList();
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



