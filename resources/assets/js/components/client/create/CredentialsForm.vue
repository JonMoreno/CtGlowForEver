
<template>
    <div>
        <div class="divider mb-0"></div>
        <p class="text-muted text-center ls-1 font-weight-bold">
            <span v-if="views.lang.english">credendtials</span>
            <span v-else>credenciales </span>
        </p>
        <form 
            v-if="views.form"
            @click="validateFormField($event.target.name)" 
            @keyup="validateFormField($event.target.name)" 
            @change="validateFormField($event.target.name)"> 
        <!-- FIRST NAME -->
            <div class="row my-5">
                <div class="form-group col-9">
                    <label class="col-form-label-lg"> 
                        <span v-if="views.lang.english">FIRST NAME</span>
                        <span v-else>PRIMER NOMBRE</span>
                    </label>
                    <input 
                        type="text" 
                        name="first_name"
                        v-model="form.first_name"
                        :style="feedback.style('first_name', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('first_name')"
                        :style="feedback.style('first_name', 'feedback')"
                    ></div>
                </div>
        <!-- MIDDLE INITIAL -->
                <div class="form-group col-3">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">MID INITIAL</span>
                        <span v-else>SEG INICIAL</span> 
                    </label>
                    <input 
                        type="text" 
                        name="mid_initial"
                        v-model="form.mid_initial"
                        :style="feedback.style('mid_initial', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('mid_initial')"
                        :style="feedback.style('mid_initial', 'feedback')"
                    ></div>
                </div>
            </div>

        <!-- LAST NAME -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">LAST NAME</span>
                        <span v-else>APELLIDO </span> 
                    </label>
                    <input 
                        type="text" 
                        name="last_name"
                        v-model="form.last_name"
                        :style="feedback.style('last_name', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('last_name')"
                        :style="feedback.style('last_name', 'feedback')"
                    ></div>
                </div>
            </div>

        <!-- EMAIL -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">EMAIL ADDRESS</span>
                        <span v-else>CORREO ELECTRÓNICO </span> 
                    </label>
                    <input 
                        type="text" 
                        name="email"
                        v-model="form.email"
                        :style="feedback.style('email', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('email')"
                        :style="feedback.style('email', 'feedback')"
                    ></div>
                </div>
            </div>

        <!-- DATE OF BIRTH -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-12 col-form-label-lg pl-0">
                        <span v-if="views.lang.english">DATE OF BIRTH</span>
                        <span v-else>FECHA DE NACIMIENTO</span> 
                    </label>
                    <div class="form-row">
                <!-- DAY -->
                        <div class="col-2">
                            <select 
                                name="day"
                                type="text" 
                                v-model="form.dob.day"
                                :style="feedback.style('day', 'input')"
                                class="form-control form-control-lg text-muted">
                                <option value="">
                                    <span v-if="views.lang.english">day</span>
                                    <span v-else>día</span>
                                </option>
                                <option v-for="day in populate.days" :value="day" :key="day">
                                    {{ day }}
                                </option>
                            </select>
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('day')"
                                :style="feedback.style('day', 'feedback')"
                            ></div>
                        </div>
                <!-- MONTH -->
                        <div class="col-5">
                            <select 
                                type="text" 
                                name="month"
                                v-model="form.dob.month"
                                :style="feedback.style('month', 'input')"
                                class="form-control form-control-lg text-muted">
                                <option value="">
                                    <span v-if="views.lang.english">month</span>
                                    <span v-else>mez</span> 
                                </option>
                                <option v-for="(month,index) in populate.months" :value="index" :key="month">
                                    {{ month }}
                                </option>
                            </select>
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('month')"
                                :style="feedback.style('month', 'feedback')"
                            ></div>
                        </div>
                <!-- YEAR -->
                        <div class="col-5">
                            <input 
                                type="text" 
                                name="year"
                                :placeholder="[views.lang.english? 'year' : 'año']"
                                v-model="form.dob.year"
                                :style="feedback.style('year', 'input')"
                                class="form-control form-control-lg text-muted">
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('year')"
                                :style="feedback.style('year', 'feedback')"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- ADDRESS -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-12 col-form-label-lg pl-0">
                        <span v-if="views.lang.english">ADDRESS</span>
                        <span v-else>DIRECCIÓN</span> 
                    </label>
                    <div class="form-row">
                <!-- FLOOR -->
                        <div class="col-4">
                            <input 
                                type="text" 
                                name="apt_floor"
                                :placeholder="[views.lang.english? 'floor' : 'piso']"
                                v-model="form.apt_floor"
                                :style="feedback.style('apt_floor', 'input')"
                                class="form-control form-control-lg text-muted">
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('apt_floor')"
                                :style="feedback.style('apt_floor', 'feedback')"
                            ></div>
                        </div>
                <!-- STREET -->
                        <div class="col-8">
                            <input 
                                type="text" 
                                name="street"
                                :placeholder="[views.lang.english? 'street' : 'calle']"
                                v-model="form.street"
                                :style="feedback.style('street', 'input')"
                                class="form-control form-control-lg text-muted">
                            <div    
                                class="f-100"
                                v-text="feedback.feedback('street')"
                                :style="feedback.style('street', 'feedback')"
                            ></div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                <!-- CITY -->
                        <div class="col-6">
                            <input 
                                type="text" 
                                name="city"
                                :placeholder="[views.lang.english? 'city' : 'ciudad']"
                                v-model="form.city"
                                :style="feedback.style('city', 'input')"
                                class="form-control form-control-lg text-muted">
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('city')"
                                :style="feedback.style('city', 'feedback')"
                            ></div>
                        </div>
                <!-- STATE -->
                        <div class="col-2">
                            <select 
                                type="text"
                                name="state" 
                                v-model="form.state"
                                :style="feedback.style('state', 'input')" 
                                class="form-control form-control-lg text-muted">
                                <option value="">
                                    <span v-if="views.lang.english">state</span>
                                    <span v-else> estado </span>
                                </option>
                                <option v-for="state in populate.states" :value="state" :key="state">
                                    {{ state }}
                                </option>
                            </select>
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('state')"
                                :style="feedback.style('state', 'feedback')"
                            ></div>
                        </div>
                <!-- ZIP CODE -->
                        <div class="col-4">
                            <input 
                                type="text"
                                name="zip"
                                v-model="form.zip"
                                :placeholder="[views.lang.english? 'zip code' : 'código postal']"
                                :style="feedback.style('zip', 'input')" 
                                class="form-control form-control-lg text-muted">
                            <div 
                                class="f-100"
                                v-text="feedback.feedback('zip')"
                                :style="feedback.style('zip', 'feedback')"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- MAIN PHONE -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">MOBILE PHONE</span>
                        <span v-else>TELÉFONO PRINCIPAL</span> 
                    </label>
                    <input 
                        type="text" 
                        name="cellular"
                        v-model="form.cellular"
                        :style="feedback.style('cellular', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('cellular')"
                        :style="feedback.style('cellular', 'feedback')"
                    ></div>
                </div>
            </div>

        <!-- EMERGENCY PHONE -->
            <div class="row my-5">
                <div class="form-group col-12">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">EMERGENCY PHONE</span>
                        <span v-else>TELÉFONO DE EMERGENCIA</span>  
                    </label>
                    <input 
                        type="text" 
                        name="emergency_phone"
                        v-model="form.emergency_phone"
                        :style="feedback.style('emergency_phone', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('emergency_phone')"
                        :style="feedback.style('emergency_phone', 'feedback')"
                    ></div>
                </div>
            </div>

        <!-- OCCUPATION -->
            <div class="row my-5">
                <div class="form-group col-9">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">OCCUPATION</span>
                        <span v-else>OCUPACIÓN</span> 
                    </label>
                    <input 
                        type="text" 
                        name="occupation"
                        v-model="form.occupation"
                        :style="feedback.style('occupation', 'input')"
                        class="form-control form-control-lg text-muted">
                    <div 
                        class="f-100" 
                        v-text="feedback.feedback('occupation')"
                        :style="feedback.style('occupation', 'feedback')"
                    ></div>
                </div>
        <!-- GENDER -->
                <div class="form-group col-3">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">GENDER</span>
                        <span v-else>GÉNERO</span>  
                    </label>
                    <select name="gender" v-model="form.gender" :style="feedback.style('gender', 'input')" type="text" class="form-control form-control-lg text-muted">
                        <option value=""> </option>
                        <option value="other"> 
                            <span v-if="views.lang.english">other</span>
                            <span v-else>otro</span> 
                        </option>
                        <option value="male">
                            <span v-if="views.lang.english">male</span>
                            <span v-else>masculino</span> 
                        </option>
                        <option value="female">
                            <span v-if="views.lang.english">female</span>
                            <span v-else>femenino</span>  
                        </option>
                    </select>
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('gender')"
                        :style="feedback.style('gender', 'feedback')"
                    ></div>
                </div>
            </div>
        <!-- REASON FOR VISIT -->
            <div class="row my-5">
                <div class=" form-group col-10">
                    <label class="col-form-label-lg">
                        <span v-if="views.lang.english">RESON FOR VISIT</span>
                        <span v-else>RAZÓN DE LA VISITA</span> 
                    </label>
                    <textarea 
                        name="visit_reason" 
                        v-model="form.visit_reason" 
                        :style="feedback.style('visit_reason', 'input')"
                        class="form-control form-control-lg text-muted" rows="4">
                    </textarea>
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('visit_reason')"
                        :style="feedback.style('visit_reason', 'feedback')"
                    ></div>
                </div>
        <!-- FIRST FACIAL -->
                <div class="form-group col-2">
                <label class="col-form-label-lg">
                    <span v-if="views.lang.english">FIRST FACIAL</span>
                    <span v-else>PRIMER FACIAL</span> 
                </label>
                    <div class="form-check">
                        <input 
                            value="0"
                            type="radio"
                            name="first_facial"
                            v-model="form.first_facial"
                            class="form-check-input big-checkbox"
                            >
                        <label class="form-check-label ml-2 mt-2"> NO </label>
                    </div>
                    <div class="form-check mt-3">
                        <input 
                            value="1"
                            type="radio"
                            name="first_facial"
                            v-model="form.first_facial"
                            class="form-check-input big-checkbox"
                            >
                        <label class="form-check-label ml-2 mt-2">
                            <span v-if="views.lang.english">YES</span>
                            <span v-else>SI</span>
                        </label>
                    </div>
                    <div 
                        class="f-100"
                        v-text="feedback.feedback('first_facial')"
                        :style="feedback.style('first_facial', 'feedback')"
                    ></div>
                </div>
            </div>
        </form>
    </div>
</template>


<script type="text/javascript">
import Moment from 'moment';
import States from '../../utilities/usa_states.js';
import FeedBack from "../../utilities/feedback_v2.js";
import Validation from "../../utilities/validation.js";
import FormRules from '../../rules/client_create_credentialsform.js';

export default {

    data: function(){
        return {
            route: '/api/clients',
            views:{
                lang: {
                    english: true,
                    spanish: false,
                },
                form: true,
                alertFail: false
            },
            position:{
                formY: window.screenY,
            },
            form:{
                first_name: '',
                mid_initial: '',
                last_name: '',
                gender: '',
                email: '',
                dob: {
                    day: '',
                    month: '',
                    year: ''
                },
                street: '',
                apt_floor: '',
                city: '',
                state: '',
                zip: '',
                cellular: '',
                emergency_phone: '',
                occupation: '',
                first_facial: '',
                visit_reason: '',
            },
            populate:{
                days: [],
                months: Moment.months(),
                states: States
            },
            feedback: new FeedBack(),
            formData: new FormData(),
            validation: new Validation(),
        }
    },

    methods:{ 
        prepFormData: function(){
            const vi = this;
            vi.formData.append('dob', //format dob.
                Moment(
                    {  
                        year: vi.form.dob.year, 
                        month: vi.form.dob.month, 
                        day: vi.form.dob.day
                    }
                ).format('YYYY-MM-DD')
            );
            for(let field in vi.form){ //append all form values.
                if(field !== 'dob'){
                    vi.formData.append(field, vi.form[field]);
                }
            }
        },
        storeClientCredentials: function(){
            const vi = this;      
            vi.formData.append('complete', 1); 
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
                        console.log("CredentialsForm.storeClientCredentials(); Error: " + error);
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
        validateCompleteForm: function(){
            let status = true;
            const vi = this;
        
            for(let field in vi.form){
                if(field == 'dob'){
                    for(let x in vi.form[field]){
                        if(!vi.validateField(x)){
                            status = false;
                        }
                    }
                }else{
                    if(!vi.validateField(field)){
                        status = false
                    }
                }
            }
            return status;
        },
        validateField: function(input){ // No _.debounce() for rapid looping.
            let value;
            input == 'day' || input == 'month' || input === 'year' ? value = this.form.dob : value = this.form;
            if(!this.validation.validate(input, value[input])){
                return this.isInvalid(input);
            }else{
                return this.clearField(input);
            }
        },
        validateFormField: _.debounce(function(input){
            let value;
            input == 'day' || input == 'month' || input === 'year' ? value = this.form.dob : value = this.form;
            if(!this.validation.validate(input, value[input])){
                this.isInvalid(input);
            }else{
                this.clearField(input);
            }
        }, 0),
        populateMonthDays: function(){
            const days = this.populate.days;
            for(let i = 1; i < 32; i++){ 
                days.push(i.toString());
            }
        }, 
        clearField: function(field) {
			this.feedback.setStyle(field, 'input', 'clear');
			this.feedback.setStyle(field, 'feedback', 'clear');
			this.feedback.setFeedBack(field, '');
			return true;
        },
        isInvalid: function(field) {
			this.feedback.setStyle(field, 'input', 'invalid');
			this.feedback.setStyle(field, 'feedback', 'invalid');
			this.feedback.setFeedBack(field, this.validation.getMessage(field));
			return false;
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
            Event.fire('OnValidationPassCredentialsForm', {form: 'credentials', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
            Event.listen('OnStoreCredentialsForm', function(){
                vi.prepFormData();
                vi.storeClientCredentials();
            });
        },
        broadCastOnSubmitIncomplete: function(){
            Event.fire('OnSubmitIncompleteCredentialsForm');
        },
        broadCastOnSubmitSuccess: function(response){
            Event.fire('OnSubmitSuccessCredentialsForm', response);
        },
        broadCastOnSubmitError: function(){
            Event.fire('OnSubmitErrorCredentialsForm');
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitCredentialsForm', function(){
                vi.validateAndSubmitForm();
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
        this.populateMonthDays();
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



