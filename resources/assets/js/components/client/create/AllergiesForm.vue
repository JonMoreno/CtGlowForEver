
<template>
    <div>
        <form 
            v-if="views.form"
            @click="validateFormField($event.target.name)" 
            @keyup="validateFormField($event.target.name)" 
            @change="validateFormField($event.target.name)"> 
        
        <!-- ALLERGIES -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">
                            LIST ANY ALLERGIC REACTIONS YOU HAVE:
                        </span>
                        <span v-else>
                            ENUMERE TODAS LAS REACCIONES ALÉRGICAS QUE TIENE:
                        </span>
                    </label>
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('allergies')"
                        :style="feedback.style('allergies', 'feedback')"
                    ></div>
                    <input-list target-name="allergies" target-arrey="allergies"></input-list>
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
import FormRules from '../../rules/client_create_allergiesform.js';

export default {

    components:{
        'input-list': InputList
    },

    data: function(){
        return {
            route: '/api/allergies',
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
                allergies: [],
            },
            feedback: new FeedBack(),
            formData: new FormData(),
            validation: new Validation(),
        }
    },

    methods:{
        storeClientAllergies: function(formData){
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
                        console.log("AllergiesForm.storeClientAllergies(); Error: " + error);
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

            if(vi.form.allergies.length != 0){
                for(let index in vi.form.allergies){
                    
                    vi.formData = null; vi.formData = new FormData();

                    vi.formData.append('medical_id',  vi.clientRef[0].reference);
                    vi.formData.append('name' , vi.form.allergies[index].value);

                    vi.storeClientAllergies(vi.formData);
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
            Event.fire('OnValidationPassAllergiesForm', {form: 'allergies', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
            Event.listen('OnStoreAllergiesForm', function(response){
                vi.clientRef = response;
                if(vi.clientRef !== false && vi.clientRef != null){
                    if(vi.validateCompleteForm()){
                        vi.loopFormData();
                    }
                }
            });
        },
        broadCastOnSubmitIncomplete: function(){
            Event.fire('OnSubmitIncompleteAllergiesForm');
        },
        broadCastOnSubmitSuccess: function(){
            Event.fire('OnSubmitSuccessAllergiesForm');
        },
        broadCastOnSubmitError: function(){
            Event.fire('OnSubmitErrorAllergiesForm');
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitAllergiesForm', function(){
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



