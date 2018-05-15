
<template>
  <div class="card mb-3 ml-xl-5 mr-xl-4 mx-2">

        <transition name="bounce">
            <div v-if="views.alertFail" class="card-body">
                <alert-fail :state="views.alertFail"></alert-fail>
            </div>
        </transition>

        <div v-if="views.main" class="card-body px-3 pt-2 pb-1 border-light-secondary rounded">
    <!-- Number Of Appt Visits -->
        <div class="badge text-primary bg-light-info posit-corner border-info border d-flex d-flex-column justify-content-center align-items-center px-1">
            #{{ visit }}
        </div>

        <form @change="validateField($event.target.name)" @keyup="validateField($event.target.name)" action="#" method="#">
        <!-- Consultation Appt List Item -->
            <div class="form-row ml-lg-4 ml-md-5">
            <!-- Title Group -->
                <!-- Label -->
                    <label class="col-6 col-md-2 col-lg-1 col-form-label d-flex flex-column align-items-center justify-content-center font-weight-bold text-dark my-4">
                        
                        <span class="h5 mb-1"> Time </span>
                        <i class="fa fa-clock-o fa-2x text-info" aria-hidden="true"></i>  
                    </label>
                <!-- Input -->
                    <div class="col-6 col-md-4 col-lg-3 d-flex d-flex-column justify-content-center align-items-center">
                        <span>
                            <input 
                                type="time"
                                name="time"
                                class="form-control form-control-sm pb-0"

                                v-model="record.time"
                                :style="feedback.style('time', 'input')"
                                :class="[views.editRecord ? 'font-weight-bold' : 'form-control-plaintext disabled']">

                            <hr class="mt-0 mb-2"/>
                            <div v-text="feedback.feedback('time')" :style="feedback.style('title','feedback')"></div>

                            <small class="text-muted font-weight-bold d-block">
                                {{allDayEvent}}
                            </small>
                        </span>
                    </div>
            <!-- Date Group -->
                <!-- Label -->
                    <label class="col-6 col-md-2 col-lg-1 col-form-label d-flex flex-column align-items-center justify-content-center font-weight-bold text-dark my-4"> 
                        
                        <span class="h5 mb-1"> Date </span>
                        <i class="fa fa-calendar fa-2x text-info" aria-hidden="true"></i>
                    </label>
                <!-- Input -->
                    <div class="col-6 col-md-4 col-lg-3 d-flex d-flex-column justify-content-center align-items-center">
                        <span>
                        <input 
                            type="date" 
                            name="date"
                            class="form-control form-control-sm"

                            v-model="record.date"
                            :style="feedback.style('date', 'input')"
                            :class="[views.editRecord ? 'font-weight-bold' : 'form-control-plaintext disabled']">
                        <hr class="mt-0 mb-2"/>
                        <div v-text="feedback.feedback('date')" :style="feedback.style('date','feedback')"></div>
                        </span>
                    </div>
            <!-- Description Group -->
                <div class="offset-2 col-10 offset-md-0 col-md-12 col-lg-4 pl-3 mb-3 mb-lg-1">

                <!-- Label -->
                    <label class="font-weight-bold pl-md-3 pl-lg-0 pt-4 pt-md-0">                                     
                        <i class="fa fa-sticky-note-o fa-2x text-info mr-1" aria-hidden="true"></i>
                        <span class="h5"> Description </span>
                        
                    </label>

                    <hr class="mt-1 mb-2"/>
                    <div v-text="feedback.feedback('description')" :style="feedback.style('description','feedback')"></div>
                <!-- TextArea -->
                    <textarea 
                        rows="3"
                        name="description"
                        class="form-control font-italic font-size-90p"
                        placeholder="________________________________________________________________________________________________________________________________________________"

                        v-model="record.description"
                        :style="feedback.style('description', 'input')"
                        :class="[views.editRecord ? '' : 'form-control-plaintext disabled']"
                    ></textarea>
                </div>
            </div>
        </form>
    <!-- Edit Button Group -->
        <div class="btn-group posit-bot-right" role="group">
            <transition name="slide-fade">
                <button 
                    type="button" 
                    class="btn btn-link text-danger fa-lg border-leftls-05 pr-2"
                    v-if="views.editRecord"
                    @click="removeListItem(index)">
                    Delete <i class="fa fa-minus-circle" aria-hidden="true"></i>
                </button>
            </transition>
            <button 
                type="button"
                class="btn btn-link  font-weight-bold ls-05 pl-3"
                @click="views.editRecord = !views.editRecord">   
                <span v-if="!views.editRecord">
                    Edit <i class="fa fa-pencil gfe-text-red fa-lg icon-align"></i>
                </span>
                <span v-else>
                    Editing
                <i class="fa fa-spinner fa-pulse gfe-text-red fa-lg icon-align"></i>
                </span>
            </button> 
        </div>

    <!-- Update At -->
        <div class="text-muted posit-bot-left-aside d-inline-block">
            Last update {{ record.updated_at}}
        </div>
    </div>
    </div>
</template>


<script type="text/javascript">

window._ = require('lodash');
import Feedback from "../utilities/feedback_v2.js";
import Validation from "../utilities/validation.js";
import AlertIconFail from "../alert/icon/fail.vue";

export default {

    components: {
        'alert-fail': AlertIconFail
    },

    props:{
        visit:{
            type: Number,
            required: true
        },
        index:{
            type: Number,
            required: true
        },
        record:{
            type: Object,
            required: true
        },
    },

    data: function(){
        return {
            views: {
                main: true,
                alertFail: false,
                editRecord: false
            },
            feedback: new Feedback(),
            validator: new Validation(),
            route: '/api/calendar-consultations/'
        }
    },
//2018-05-15T00:56:49.884323+00:00
    computed:{
        allDayEvent: function(){
            if(this.record.time == null || this.record.time.length == 0){
                return "all day event?";
            }
        }
    },

    methods:{
        numberOfAppts: function(index){
            return Number(this.list.length) - index;
        },
        initForm: function(){
            const vi = this;

            for(let field in vi.formRules()){
                vi.$set(vi.feedback.styleFeedBacks, [field], '');
                vi.$set(vi.feedback.styleInputs, [field], '', true);
                vi.$set(vi.feedback.messages, [field], '');
            }
            vi.validator.setRules(vi.formRules());
        },
        formRules: function(){
            return {
                date: { type: 'date', required: true },

                time: { type: 'time', required: false },

                description: { type: 'text', min: 2, max: 250, type: "text", required: false}
            }
        },
        isValid: function(field) { 
			this.feedback.setStyle(field, 'input', 'valid'); 
            this.feedback.setStyle(field, 'feedback', 'valid');

            if(this.record[field].length > 0){ //time/date: hack
                this.feedback.setFeedBack(field, 'looks great.');
            }else{
                this.feedback.setFeedBack(field, '');
            }
            return true;
        },
        isInvalid: function(field) { 
			this.feedback.setStyle(field, 'input', 'invalid');
			this.feedback.setStyle(field, 'feedback', 'invalid');
			this.feedback.setFeedBack(field, this.validator.getMessage(field));
            return false;
        },
        validateField: _.debounce(function(input){
            if(this.validator.validate(input, this.record[input])){
                this.isValid(input);
                this.updateListItme(input);
            }else{
               this.isInvalid(input);
            }
        }, 1000),
        updateListItme: function(field){
            const vi = this;

            axios.patch(vi.route + vi.record.id, { [field]: vi.record[field] } )
                .then( function(response){
                    vi.record.updated_at = response.data;
                    vi.broadCastOnClientApptUpdate();
                })
                .catch( function(error){
                    if(error.response.data.errors){
                        console.log('Errors:');
                        let errors = error.response.data.errors;
                        for(let input in errors){
                            vi.feedback.setStyle(input, 'input', 'inValid');
                            vi.feedback.setStyle(input, 'feedback', 'inValid');
                            vi.feedback.setFeedBack(input, errors[input][0]);
                            console.log(errors[input][0]);
                        }
                    
                    }else{
                        console.log('ClientListItem.updateListItem(); Error: ' + error.response);
                        vi.views.alertFail = true;
                        vi.views.main = false;
                    }
                })
        },
        removeListItem: function(index){
            const vi = this;
            axios.delete( vi.route + vi.record.id)
                .then( function(response){
                    vi.broadCastOnClientApptRemove(index);
                })
                .catch( function(error){
                    console.log('ClientListItem.removeListItem(); Error: ' + error.response);
                    vi.views.alertFail = true;
                    vi.views.main = false;
                });
        },
        broadCastOnClientApptUpdate: function(){
            Event.fire('onClientApptUpdate');
        },
        broadCastOnClientApptRemove: function(index){
            Event.fire('onClientApptRemove', index);
        }
    },
    

    created: function(){
        this.initForm();
    }
}
</script>


// COMPONENT STYLING
<style scoped>
    .posit-bot-right{
        position: absolute;
        right: 0px;
        bottom: -5px;
    }
    .posit-bot-left-aside{
        position: relative;
        left: 30px;
        bottom: -1px;
    }
    .posit-corner{
        position: absolute;
        left: -10px;
        top: 0px;
        height: 100%;
        font-size: 145% !important;
    }
    .icon-align{
        position: relative;
        bottom: 5px;
        left: -3px;
    }
    .font-size-90p{
        font-size: 90% !important;
    }
</style>
