
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
        <!-- HAVE YOU EVER BEEN DIAGNOSED WITH ANY OF THE FOLLOWING ILLNESSES -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <div class="form-row">
                        <label class="col-12 col-form-label-lg">
                            <span v-if="views.lang.english">
                                HAVE YOU EVER BEEN DIAGNOSED WITH ANY OF THE FOLLOWING ILLNESSES?
                            </span>
                            <span v-else>
                                ¿ALGUNA VEZ HA SIDO DIAGNOSTICADO CON CUALQUIERA DE LAS SIGUIENTES ENFERMEDADES?
                            </span>
                        </label>
                        <div 
                            class="col-12 f-100 text-center mt-0 mb-3"
                            v-text="feedback.feedback('illnesses')"
                            :style="feedback.style('illnesses', 'feedback')"
                        ></div>
                    </div>
                    <div class="form-row">
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="cancer">
                                <label class="form-check-label text-uppercase">cancer</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="artritis">
                                <label class="form-check-label text-uppercase">artritis</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="insomnia">
                                <label class="form-check-label text-uppercase">insomnia</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="skin disease">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">skin disease</span>
                                    <span v-else>efermedad de piel</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input  v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="epilepsy">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">epilepsy</span>
                                    <span v-else>epilepsia</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="traumatisms">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">traumatisms</span>
                                    <span v-else>traumatismos</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="thyroids">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">thyroids</span>
                                    <span v-else>tiroides</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="migranes">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">migranes</span>
                                    <span v-else>migrañas</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="pneumonia">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">pneumonia</span>
                                    <span v-else>neumonia</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="diabetes">
                                <label class="form-check-label text-uppercase">diabetes</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="hepatitis">
                                <label class="form-check-label text-uppercase">hepatitis</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="rubella">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">rubella</span>
                                    <span v-else>rubeola</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="herpes">
                                <label class="form-check-label text-uppercase">herpes</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="asthma">
                                <label class="form-check-label text-uppercase">asthma</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="eczema">
                                <label class="form-check-label text-uppercase">eczema</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="varicose veins">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">varicose veins</span>
                                    <span v-else>venas variscosas</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="vih">
                                <label class="form-check-label text-uppercase">vih</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="lupus">
                                <label class="form-check-label text-uppercase">lupus</label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="infections">
                                <label class="form-check-label text-uppercase">
                                    <span v-if="views.lang.english">infections</span>
                                    <span v-else>infecciones</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline mr-0">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="high blood pressure">
                                <small class="text-uppercase">
                                    <span v-if="views.lang.english">high blood pressure</span>
                                    <span v-else>presion alta</span>
                                </small>
                            </div>
                        </div>
                        <div class="col-4 pl-5 py-2">
                            <div class="form-check form-check-inline">
                                <input v-model="form.illnesses" name="illnesses" class="form-check-input big-checkbox" type="checkbox" value="heart problems">
                                <small class="text-uppercase">
                                    <span v-if="views.lang.english">heart problems</span>
                                    <span v-else>problemas cardiacos</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <!-- LIST ANY OTHER ILLNESSES OR MEDICAL CONDITIONS -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">
                            LIST ANY OTHER ILLNESSES OR MEDICAL CONDITIONS:
                        </span>
                        <span v-else>
                            ENUMERE CUALQUIER OTRA ENFERMEDAD O CONDICIONES MÉDICAS:
                        </span>
                    </label>
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('alt_illnesses')"
                        :style="feedback.style('alt_illnesses', 'feedback')"
                    ></div>
                    <input-list target-name="alt_illnesses" target-arrey="alt_illnesses"></input-list>
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
import FormRules from '../../rules/client_create_illnessesform.js';

export default {

    components:{
        'input-list': InputList
    },

    data: function(){
        return {
            route: '/api/illnesses',
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
                illnesses: [],
                alt_illnesses: [],
            },
            feedback: new FeedBack(),
            formData: new FormData(),
            validation: new Validation(),
        }
    },

    methods:{ 
        storeClientIllnesses: function(formData){
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
                        console.log("IllnessesForm.storeClientIllnesses(); Error: " + error);
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
            if(vi.form.illnesses.length != 0 && vi.form.alt_illnesses != 0){
                for(let index in vi.form.illnesses){
                    
                    vi.formData = null; vi.formData = new FormData();

                    vi.formData.append('medical_id',  vi.clientRef[0].reference);
                    vi.formData.append('name' , vi.form.illnesses[index]);

                    vi.storeClientIllnesses(vi.formData);

                }

                for(let index in vi.form.alt_illnesses){
                    
                    vi.formData = null; vi.formData = new FormData();

                    vi.formData.append('medical_id',  vi.clientRef[0].reference);
                    vi.formData.append('name' , vi.form.alt_illnesses[index].value);

                    vi.storeClientIllnesses(vi.formData);
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
            Event.fire('OnValidationPassIllnessesForm', {form: 'illnesses', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
            Event.listen('OnStoreIllnessesForm', function(response){
                vi.clientRef = response;
                if(vi.clientRef !== false && vi.clientRef != null){
                    if(vi.validateCompleteForm()){
                        vi.loopFormData();
                    }
                }
            });
        },
        broadCastOnSubmitIncomplete: function(){
            Event.fire('OnSubmitIncompleteIllnessesForm');
        },
        broadCastOnSubmitSuccess: function(){
            Event.fire('OnSubmitSuccessIllnessesForm');
        },
        broadCastOnSubmitError: function(){
            Event.fire('OnSubmitErrorIllnessesForm');
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitIllnessesForm', function(){
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
        width: 25px !important; 
        height: 25px !important;
    }  
    .f-100{
        font-size:  100% !important;
    } 
</style>



