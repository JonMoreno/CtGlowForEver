<template>
    <transition name="fade">
        <div v-if="edit || create" class="mt-2"> 
        <!-- Alert On Fail -->
            <transition name="fade">
                <alert-fail :state="views.onFail"></alert-fail>
            </transition>
        <!-- Alert On Success -->
            <transition name="fade">
                <alert-success :state="views.onSuccess">{{ successMSG }}</alert-success>
            </transition>
            
        <!-- EVENT FORM TRANSITION -->
            <transition name="fade">
            <!-- EVENT card card-body -->
                <div v-if="views.form" class="card card-body mt-2 pt-0">
                <!-- FORM TITLE -->
                    <h6 class="text-dark mb-3 bg-light-primary text-uppercase text-center ls-1 pt-2 pb-0 font-weight-bold border-bottom-primary">Consultation Apt.</h6>

                <!-- EVENT FORM -->
                    <form @change="validateField($event.target.name)" @keyup="validateField($event.target.name)" enctype="application/x-www-form-urlencoded">
                    <!-- Event title -->
                        <label class="font-weight-bold">Event Title:</label>
                    <!-- Full Name -->
                        <div class="form-group form-row pl-2 ">
                        <!-- label-->
                            <label class="col-form-label col-12 col-sm-3">Client:</label>
                        <!-- input -->
                            <div class="col-12 col-sm-9">
                                <div class="input-group">
                                <!-- Input field -->
                                    <input 
                                        v-model="title"
                                        class="form-control form-control-sm bg-light-secondary disabled">
                                <!-- Input group addon -->
                                    <input-addon-dropdown
                                        addon="append" 
                                        drop="dropright"
                                        btn-class="btn-input-addon px-1">
                                        <div slot="btn-title">
                                            <i class="fa fa-question-circle text-info" aria-hidden="true"></i>
                                        </div>
                                        <div slot="drop-menu" class="px-3 bg-light-info">
                                            <small v-if="create">To change client. Please, search for client above and select the desired name.</small>
                                            <small v-if="edit"> You can not change the client's name. Please, go back to the calendar and select the event with the client you prefer or create a new event.</small>
                                        </div>
                                    </input-addon-dropdown>
                                </div>
                            </div>
                        </div>

                    <!-- Appt. Time -->
                        <div class="form-group form-row pl-2 ">
                        <!-- label -->
                            <label class="col-form-label col-12 col-sm-3">Time:</label>
                        <!-- input -->   
                            <div class="col-12 col-sm-9">
                                <div class="input-group custom-input-group-addon-sm">
                                <!-- Input field -->
                                    <input
                                        type="time"
                                        name="time" 
                                        v-model="time"
                                        :style="helper.style('time', 'input')"
                                        class="form-control form-control-sm">
                                <!-- Input group addon -->
                                    <input-addon-dropdown
                                        addon="append" 
                                        drop="dropright"
                                        btn-class="btn-input-addon px-1">
                                        <div slot="btn-title">
                                            <i class="fa fa-question-circle text-info" aria-hidden="true"></i>
                                        </div>
                                        <div slot="drop-menu" class="px-3 bg-light-info">
                                            <small>If the time is left empty the event will be scheduled as an ALL DAY EVENT.</small>
                                        </div>

                                    </input-addon-dropdown>
                                </div>
                                <div v-text="helper.feedback('time')"
                                    :style="helper.style('time', 'feedback')"
                                ></div>
                            </div>
                        </div>    

                    <!-- Event Date -->
                        <div class="form-group form-row">
                        <!-- label -->
                            <label class="col-form-label col-12 font-weight-bold">Event Date:</label>
                        <!-- input -->
                            <div class="col-12 offset-sm-3 col-sm-9">
                                <div class="input-group custom-input-group-addon-sm">
                                <!-- Input field -->
                                    <input 
                                        type="date" 
                                        name="date"
                                        v-model="date" 
                                        :class="{'bg-light-secondary disabled' : create}"
                                        :style="helper.style('date', 'input')"
                                        class="form-control form-control-sm px-1">
                                <!-- Input group addon -->
                                    <input-addon-dropdown
                                        v-if="create"
                                        addon="append" 
                                        drop="dropright"
                                        btn-class="btn-input-addon px-1">
                                        <div slot="btn-title">
                                            <i class="fa fa-question-circle text-info" aria-hidden="true"></i>
                                        </div>
                                        <div slot="drop-menu" class="px-3 bg-light-info">
                                            <small>To change the date. Please go back to the callendar and pick a different day.</small>
                                        </div>
                                    </input-addon-dropdown>
                                </div>
                            <!-- Feedabck -->
                                <div v-text="helper.feedback('date')" class=""
                                    :style="helper.style('date', 'feedback')"
                                ></div>
                            </div>
                        </div>
                    <!-- Event Description -->
                        <div class="form-group form-row">
                        <!-- label -->
                            <label class="col-form-label col-sm-12 text-left font-weight-bold">
                                Event Description:
                            </label>
                        <!-- input -->
                            <div class="col-12">
                                <textarea
                                    rows="3"
                                    type="text"
                                    name="description" 
                                    v-model="description"
                                    :style="helper.style('description', 'input')"
                                    class="form-control form-control-sm">
                                </textarea>
                                <div class="text-center"
                                    v-text="helper.feedback('description')"
                                    :style="helper.style('description', 'feedback')"
                                ></div>
                            </div>
                        </div>
                    </form>

                <!-- Divider -->
                    <div class="dropdown-divider"></div>

                
                    <div class="text-center mt-4">
                    <!-- Submit button -->
                        <button 
                            type="button"
                            @click="onSubmit()"
                            :class="{disabled : !submitBtn}"
                            class="btn btn-outline-primary btn-block btn-sm font-weight-bold">
                            <i v-if="views.submitIcon" class="fa fa-spinner fa-spin fa-lg"></i>
                            <i v-else class="fa fa-floppy-o" aria-hidden="true"></i>
                            <span v-if="create">
                                Save Event
                            </span>
                            <span v-else>
                                Update Event
                            </span>
                        </button>
                    <!-- Delete button -->
                        <button 
                                v-if="edit"
                                type="button"
                                @click="deleteConsultEvent()"
                                :class="{disabled : !deleteBtn}"
                                class="btn btn-outline-danger btn-block btn-sm font-weight-bold mt-4">
                            <i class="fa fa-minus-circle" aria-hidden="true"></i> Delete Event
                        </button>
                    </div>

                </div><!-- ../card card-body -->
            </transition><!-- ../EVENT FORM TRANSITION -->  
        </div>
    </transition>
</template>


<script type="text/javascript">

//------------------------------------------------------
// DEPENDENCIES:
//------------------------------------------------------
window._ = require('lodash');
const moment = require('moment');
import FeedBack from "../utilities/feedback_v2.js";
import AlertIconFail from '../alert/icon/fail.vue';
import Validation from "../utilities/validation.js";
import AlertIconSuccess from '../alert/icon/success.vue';
import InputAddon from '../main/dropdown/InputAddon.vue';


export default {
/*------------------------------------------------------
 | COMPONENT: Consultation Event
 |------------------------------------------------------
 | This will serve as a small component for 
 | creating consultation calendar events.
 |
*/

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components: {
        'alert-fail': AlertIconFail, 
        'alert-success': AlertIconSuccess,

        'input-addon-dropdown': InputAddon
    },
//------------------------------------------------------
// PROPERTIES
//------------------------------------------------------
    props: {
        edit: {
            type: Boolean,
            default: false,
            required: false
        },
        fields: {
            type: Object,
            required:false
        },
        create: {
            type: Boolean,
            default: false,
            required: false
        }
    },
//------------------------------------------------------
// REACTIVE DATA
//------------------------------------------------------
    data: function() {
        return {
            route: '/api/calendar-consultations',
            views: {
                form: true,
                onFail: false,
                onSuccess: false,
                submitIcon: false
            },
            helper: new FeedBack(),
            form: new Validation(),
            formData: new FormData(),
            altered: {
                color: '#007bff',
                textColor: '#ffffff'
            },
            submitBtn: true,
            deleteBtn: true,
            successMSG: null
        }
    },
//------------------------------------------------------
// COMPUTED PROPERTIES
//------------------------------------------------------
    computed: {
        title: {
            get: function(){
                this.formData.delete('title');
                if(this.create){
                    return this.fields.client.first_name +  ' ' + this.fields.client.last_name;
                }
                if(this.edit){
                    return this.fields.title;
                }
            },
        },
        date: {
            get: function(){
                this.formData.delete('date');
                if(this.create){
                    return this.fields.date;
                }
                if(this.edit){
                    return this.$moment(this.fields.start).format('YYYY-MM-DD');
                }
            },
            set: function(val){
                if(this.create){
                    this.fields.date = this.fields.date;
                }
                if(this.edit){
                    this.fields.start = this.$moment(val);
                }
            }
        },
        time: {
            get: function(){
                this.formData.delete('time');
                if(this.create){
                    if(this.fields.time == null){
                        return '';
                    }else{
                        return this.fields.time;
                    }
                }
                if(this.edit){
                    if(this.fields.time == null){
                        return '';
                    }else{
                        return this.fields.time;
                    }
                }
            },
            set: function(val){
                if(this.create){
                    this.fields.time = val;
                }
                if(this.edit){
                    this.fields.time = val;
                }
            }
        },
        description: {
            get: function(){
                this.formData.delete('description');
                if(this.create){
                    return this.fields.description;
                }
                if(this.edit){
                    return this.fields.description;
                }
            },
            set: function(val){
                if(this.create){
                    this.fields.description = val;
                }
                if(this.edit){
                    this.fields.description = val;
                }
            }
        }
    },
//------------------------------------------------------
// COMPONENT METHODS
//------------------------------------------------------
    methods: {
    //--------------------------------------------------
	// HTTP REQUESTS
    //--------------------------------------------------
        deleteConsultEvent: function(){
            const vi = this;
            axios.delete(vi.route + '/' + vi.fields.id)
                .then( function(response){
                    vi.views.form = false;
                    vi.broadCastOnConsultEventRemove(vi.fields.id);
                    setTimeout( function(){
                        vi.successMSG = 'This calendar event has been removed!';
                        vi.views.onSuccess = true;
                    },400);
                    vi.broadCastOnConsultEventRemove(vi.fields.id);
                })
                .catch( function(error){
                    console.log('ConsultEventForm.deleteConsultEvent() Error:' + error.response);
                    vi.views.form = false;
                    vi.views.onFail = true;
                });

        },
        storeConsultEvent: function(){
            const vi = this;
            vi.formData.append('client_id', vi.fields.client.id);
            axios.post(vi.route, vi.formData)
                .then( function(response){
                    vi.views.form = false;
                    setTimeout( function(){
                        vi.views.onSuccess = true;
                    },400);
                    const eventObj = vi.eventObjTransform(response.data, vi.altered.color, vi.altered.textColor);
                    vi.broadCastOnConsultEventCreate(eventObj);
                })
                .catch( function(error){
                    if(error.response.data.errors){
                        vi.submitBtn = true;
                        const backEnd = error.response.data.errors;
                        for(let error in backEnd){
                            vi.helper.setStyle(error, 'input', 'invalid');
                            vi.helper.setStyle(error, 'feedback', 'invalid');
                            vi.helper.setFeedBack(error,  backEnd[error][0]);
                        }
                    }else{
                        console.log('ConsultationEvent.storeConsultEvent() Error:' + error.response);
                        vi.views.form = false;
                        vi.views.onFail = true;
                    } 
                });

        },
        putConsultEvent: function(){
            const vi = this;
            let update = vi.dataUrlDecoded(vi.formData, ['title'])
            axios.put(vi.route + '/' + vi.fields.id, update)
                .then( function(response){
                    vi.views.form = false;
                    setTimeout( function(){
                        vi.views.onSuccess = true;
                    },400);
                    vi.fields.start = vi.eventDateTimeTransform2(vi.fields.start, vi.fields.time);
                    vi.fields.allDay = vi.fields.time != null ? false : true;
                    vi.fields.color = vi.altered.color;
                    vi.fields.textColor = vi.altered.textColor;
                    vi.broadCastOnConsultEventUpdate(vi.fields);
                })
                .catch( function(error){
                    if(error.response.data.errors){
                        vi.submitBtn = true;
                        let backEnd = error.response.data.errors;
                        for(let error in backEnd){
                            console.log(error + backEnd[error]);
                            vi.helper.setStyle(error, 'input', 'invalid');
                            vi.helper.setStyle(error, 'feedback', 'invalid');
                            vi.helper.setFeedBack(error,  backEnd[error][0]);
                        }
                    }else{
                        console.log('ConsultationEvent.storeConsultEvent() Error:' + error.response);
                        vi.views.form = false;
                        vi.views.onFail = true;
                    } 
                });

        },
        patchEventAlter: function(originalEventObj){
            let vi = this;
            let latestDate = originalEventObj.start.format('YYYY-MM-DD');
            let latestTime;
            if(originalEventObj.allDay){
                latestTime = null;
                originalEventObj.time = null;
            }else{
                originalEventObj.time = originalEventObj.start.format('HH:mm');
                latestTime = originalEventObj.start.format('HH:mm');
            }
            axios.patch(vi.route + '/' + originalEventObj.id, 
                { 
                    date: latestDate ,
                    time: latestTime
                })
                .then( function(response){

                    originalEventObj.color = vi.altered.color;
                    originalEventObj.textColor = vi.altered.textColor;

                    vi.broadCastOnConsultEventUpdate(originalEventObj);

                })
                .catch( function(error){
                    const ms = 'ConsultationEvents.patchConsultEvent()' + error;
                    vi.broadCastOnFullCalendarFail(ms);
                });

        },
    //--------------------------------------------------
	// EVENT & DATA MUTATION
    //--------------------------------------------------
        dataUrlDecoded: function(formData, exclude = []){
            let decoded = {}; 
            for(var pair of formData.entries()) {
                for(let out in exclude){
                    if(pair[0] != exclude[out]){
                        decoded[pair[0]] = pair[1];
                    }
                }
            };
            return decoded;

        },
        eventObjTransform: function(consultation, bgColor = '', textColor = ''){
            const vi = this;
            const eventObj = {
                // Required Props:
                id: consultation.id,
                title: consultation.client.first_name+ ' ' +consultation.client.last_name,
                start: vi.eventDateTimeTransform(consultation.date + consultation.time),
                allDay: consultation.time ? false : true,
                description: consultation.description,
                color: bgColor,
                textColor: textColor,

                //Custom Props
                time: vi.eventTimeTransform(consultation),
                eventType: 'consultation',
                client: {
                    id: consultation.client.id,
                    first_name: consultation.client.first_name,
                    last_name: consultation.client.last_name,
                }
            };
            return eventObj;

        },
        eventTimeTransform: function(consult){
            if(consult !== null){
                return moment(consult.time, 'HH:mm:ss').format('HH:mm');
            }else{
                return null;
            }

        },
        eventDateTimeTransform: function(date, time = false){
            //let temp = moment(date, 'YYYY-MM-DD').format('YYYY-MM-DD');
            return moment(date + time, "YYYY-MM-DD HH:mm"); 

        },
        eventDateTimeTransform2: function(date, time = false){
            let temp = moment(date, 'YYYY-MM-DD').format('YYYY-MM-DD');
            if(time != null){
                return moment(temp + time, "YYYY-MM-DD HH:mm"); 
            }else{
                return temp;
            }
        }, 
    //--------------------------------------------------
	// FORM VALIDATION & EVENTS
    //--------------------------------------------------  
        rules: function(){
            return {
                title: {
                    min: 2,  
                    max: 50,
                    type: 'text',
                    required: true
                },
                date: {
                    min: 10,
                    max: 10,
                    type: 'date',
                    required: true
                },
                time: {
                    min: 4,
                    max: 7,
                    type: 'time',
                    required: false
                },
                description: {
                    min: 2,  
                    max: 250,
                    type: 'text',
                    required: false
                },
            }
        },
        initForm: function(){ // edit: true
            let vi = this;
            for(let field in vi.rules()){      
                vi.$set(vi.helper.styleFeedBacks, [field], '');
                vi.$set(vi.helper.styleInputs, [field], '');
                vi.$set(vi.helper.messages, [field], '');
            }
            vi.form.setRules(vi.rules());
            
        },
        isValid: function(field) { // edit: true
			this.helper.setStyle(field, 'input', 'valid'); 
            this.helper.setStyle(field, 'feedback', 'valid');
            if(this[field].length > 0){
                this.helper.setFeedBack(field, 'looks great!');
            }
            return true;
            
        },
        isInvalid: function(field) { // edit: true
			this.helper.setStyle(field, 'input', 'invalid');
			this.helper.setStyle(field, 'feedback', 'invalid');
			this.helper.setFeedBack(field, this.form.getMessage(field));
            return false;
            
		},
        validateField: _.debounce(function(input){ // edit: true
            let vi = this;
            if(vi.form.validate(input, vi[input])){
                return vi.isValid(input);
            }
            return vi.isInvalid(input);

        }, 500),
        validateFullForm: function(){ // edit: true
            let vi = this;
            let readyStatus = true;

            for(let field in vi.rules()){
                if(vi.validateField(field)){
                    vi.formData.append(field, vi[field]);
                }else{
                    vi.formData.delete(field);
                    readyStatus = false
                }
            }
            return readyStatus;   

        },
        onSubmit: function(){ 
            if(this.validateFullForm()){
                this.views.submitIcon = true; // loading icon.
                this.submitBtn = false; // disable submit:
                if(this.edit){
                    this.putConsultEvent();
                }else if(this.create){
                    this.storeConsultEvent();
                } 
            }

        },
    //--------------------------------------------------
	// BROADCASTING TO & FROM COMPONENTS 
    //--------------------------------------------------
        broadCastOnConsultEventCreate: function(eventObj){
            Event.fire('onConsultEventCreate', eventObj);

        },
        broadCastOnConsultEventUpdate: function(originalEventObj){ 
            Event.fire('onConsultEventUpdate', originalEventObj);

        },
        broadCastOnConsultEventRemove: function(eventId){
            Event.fire('onConsultEventRemove', [eventId]);

        },
        listenOnConsultEventFormAlter: function(){
            const vi = this;
            Event.listen('onConsultEventFormAlter', function(originalEventObj){
                vi.patchEventAlter(originalEventObj); //alter Date & Time.
            });

        },
        listenOnConsultEventFormReset: function(){
            const vi = this;
            Event.listen('onConsultEventFormReset', function(){
                vi.resetComponent();
            });

        },
    //--------------------------------------------------
	// COMPONENT RESET
    //--------------------------------------------------
        resetComponent: function(){
            Object.assign(this.$data, this.$options.data());
            this.initForm(); 
            
        },
    },
//------------------------------------------------------
// LYFECYCLE HOOKS
//------------------------------------------------------
    mounted: function() {
        this.initForm(); 
        this.listenOnConsultEventFormReset();
        this.listenOnConsultEventFormAlter();
        
    }
}
</script>

<style scoped>
    .line-height-80p{
        line-height: 80%;
    }
    .border-bottom-primary{
       border-bottom: 4px solid #007bff !important;
    }

</style>


