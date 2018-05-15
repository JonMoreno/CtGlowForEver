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
                    <h6 class="text-dark bg-light-info text-uppercase text-center ls-1 pb-0 pt-2 font-weight-bold border-bottom-info">Custom Calendar Event</h6>

                <!-- EVENT FORM -->
                    <form @change="validateField($event.target.name)" @keyup="validateField($event.target.name)" enctype="application/x-www-form-urlencoded">

                    <!-- Title -->
                        <div class="form-group form-row">
                        <!-- label-->
                            <label class="col-form-label col-12 font-weight-bold">Event Title:</label>
                        <!-- input -->
                            <div class="col-12 offset-sm-3 col-sm-9">
                                <div class="input-group">
                                <!-- Input field -->
                                    <input 
                                        type="text"
                                        name="title"
                                        v-model="title"
                                        class="form-control form-control-sm"
                                        :style="helper.style('title', 'input')">
                                </div>
                                <div v-text="helper.feedback('title')"
                                     :style="helper.style('title', 'feedback')"
                                ></div>
                            </div>
                        </div>

                    <!-- Time -->
                        <div class="form-group form-row ">
                        <!-- label -->
                            <label class="col-form-label col-12 font-weight-bold">Event Time:</label>
                        <!-- input -->   
                            <div class="col-12 offset-sm-3 col-sm-9">
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

                    <!-- Date -->
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
                                        class="form-control form-control-sm">
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
                                <div v-text="helper.feedback('date')" 
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

                <!-- Action Buttons -->
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
                                Save                                
                            </span>
                            <span v-else>
                                Update Event
                            </span>
                        </button>
                    <!-- Delete button -->
                        <button 
                                v-if="edit"
                                type="button"
                                @click="deleteCustomEvent()"
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
 | COMPONENT: Custom Event
 |------------------------------------------------------
 | This will serve as a small component for 
 | creating custom calendar events.
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
            route: '/api/calendar-customs',
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
                color: '#17a2b8',
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
                return this.fields.title;

            },
            set: function(val){
                this.fields.title = val;
            }
        },
        date: {
            get: function(){
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
        deleteCustomEvent: function(){
            const vi = this;
            axios.delete(vi.route + '/' + vi.fields.id)
                .then( function(response){
                    vi.views.form = false;
                    setTimeout( function(){
                        vi.views.onSuccess = true;
                        vi.successMSG = 'This calendar event has been removed!';
                    },400);
                    vi.broadCastOnCustomEventRemove(vi.fields.id);
                })
                .catch( function(error){
                    console.log('CustomEventForm.deleteCustomEvent() Error:' + error.response);
                    vi.views.form = false;
                    vi.views.onFail = true;
                });

        },
        storeCustomEvent: function(){
            const vi = this;
            axios.post(vi.route, vi.formData)
                .then( function(response){
                    vi.views.form = false;
                    setTimeout( function(){
                        vi.views.onSuccess = true;
                    },400);
                    const eventObj = vi.eventObjTransform(response.data, vi.altered.color, vi.altered.textColor);
                    vi.broadCastOnCustomEventCreate(eventObj);
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
                        console.log('CustomationEvent.storeCustomEvent() Error:' + error.response);
                        vi.views.form = false;
                        vi.views.onFail = true;
                    } 
                });

        },
        putCustomEvent: function(){
            const vi = this;

            let update = vi.dataUrlDecoded(vi.formData);
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
                    vi.broadCastOnCustomEventUpdate(vi.fields);
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
                        console.log('CustomationEvent.storeCustomEvent() Error:' + error.response);
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

            let counter = 0;
            axios.patch(vi.route + '/' + originalEventObj.id, 
                { 
                    date: latestDate ,
                    time: latestTime
                })
                .then( function(response){

                    originalEventObj.color = vi.altered.color;
                    originalEventObj.textColor = vi.altered.textColor;

                    vi.broadCastOnCustomEventUpdate(originalEventObj);

                })
                .catch( function(error){
                    const ms = 'CustomationEvents.patchCustomEvent()' + error;
                    vi.broadCastOnFullCalendarFail(ms);
                });

    },
    //--------------------------------------------------
	// FORM VALIDATION & EVENTS
    //--------------------------------------------------  
        rules: function(){
            return {
                title: {
                    min: 2,  
                    max: 100,
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
                    min: 0,
                    max: 7,
                    type: 'time',
                    required: false
                },
                description: {
                    min: 2,  
                    max: 250,
                    type: 'text',
                    required: true
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
            }else{
                this.helper.setFeedBack(field, '');
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
                vi.isValid(input);
            }
            else{
                vi.isInvalid(input);
            }
        }, 500),
        validateFullForm: function(){ // edit: true
            let vi = this;
            let status = true;
            for(let field in vi.rules()){
                if(vi.form.validate(field, vi[field])){
                   vi.isValid(field);
               }else{
                   status = false;
                   vi.isInvalid(field);
               }
            }
            return status;   
        },
        appendFormFields: function(){
            for(var field in this.rules()){
                this.formData.append(field, this[field]);
            }

        },
        onSubmit: function(){ 
            if(this.validateFullForm()){
                this.views.submitIcon = true; // loading icon.
                this.submitBtn = false; // disable re-submit.
                this.appendFormFields(); // add form values.

                if(this.edit){
                    this.putCustomEvent();
                }else if(this.create){
                    this.storeCustomEvent();
                } 
            }

        },
     //--------------------------------------------------
	// EVENT & DATA MUTATION:
    //--------------------------------------------------
        dataUrlDecoded: function(formData, exclude = []){
            let decoded = {}; 
            for(var pair of formData.entries()) {
                decoded[pair[0]] = pair[1];
            };
            return decoded;

        },
        eventObjTransform: function(custom, bgColor = '', textColor = ''){
            const vi = this;
            const eventObj = {
                // Required Props:
                id: custom.id,
                title: custom.title,
                start: vi.eventDateTimeTransform(custom.date + custom.time),
                allDay: custom.time ? false : true,
                description: custom.description,
                color: bgColor,
                textColor: textColor,

                //Custom Props
                time: vi.eventTimeTransform(custom),
                eventType: 'custom',
            };
            return eventObj;

        },
        eventTimeTransform: function(custom){
            if(custom !== null){
                return moment(custom.time, 'HH:mm:ss').format('HH:mm');
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
	// BROADCASTING TO & FROM COMPONENTS 
    //--------------------------------------------------
        broadCastOnCustomEventCreate: function(eventObj){
            Event.fire('onCustomEventCreate', eventObj);

        },
        broadCastOnCustomEventUpdate: function(originalEventObj){ 
            Event.fire('onCustomEventUpdate', originalEventObj);

        },
        broadCastOnCustomEventRemove: function(eventId){
            Event.fire('onCustomEventRemove', [eventId]);

        },
        listenOnCustomEventFormAlter: function(){
            const vi = this;
            Event.listen('onCustomEventFormAlter', function(originalEventObj){
                vi.patchEventAlter(originalEventObj); //alter Date & Time.
            });

        },
        listenOnCustomEventFormReset: function(){
            const vi = this;
            Event.listen('onCustomEventFormReset', function(){
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
        this.listenOnCustomEventFormReset();
        this.listenOnCustomEventFormAlter();
        
    }
}
</script>

<style scoped>
    .line-height-80p{
        line-height: 80%;
    }
    .border-bottom-info{
        border-bottom: 4px solid #17a2b8 !important;
    }

</style>


