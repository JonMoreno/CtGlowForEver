//COMPONENT TEMPLATE
<template>
    <div class="card card-body bg-light text-dark">
    <!-- Alert On Fail -->
        <transition name="fade">
            <alert-fail :state="show.onFail"></alert-fail>
        </transition>
    <!-- Alert On Success -->
        <transition name="fade">
            <alert-success :state="show.onSuccess"></alert-success>
        </transition>

    <!-- Main View -->
    <div v-if="show.form">
            <i class="fa fa-angle-double-down fa-2x pos-top-right text-light-secondary" aria-hidden="true"></i>
        <!-- Client Form -->
            <form 
                action="#"
                class="px-4 py-3"
                @change="validateField($event.target.name)"
                @keyup="validateField($event.target.name)">
            <!-- First Name -->
                <div class="form-group">
                    <label class="text-primary"><i class="fa fa-plus-square-o" aria-hidden="true"></i> First Name:</label>
                    <input 
                        name="first_name" 
                        type="text" 
                        placeholder="First Name"
                        v-model.trim="client.first_name"
                        class="form-control form-control-sm mb-2"
                        :style="helper.style('first_name', 'input')"
                    >
                    <div v-text="helper.feedback('first_name')"
                        :style="helper.style('first_name', 'feedback')"
                    ></div>
                </div>
            <!-- Last Name -->  
                <div class="form-group">
                    <label class="text-primary"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Last Name:</label>
                    <input 
                        type="text"
                        name="last_name"
                        placeholder="Last Name"
                        v-model.trim="client.last_name"
                        class="form-control form-control-sm mb-2"
                        :style="helper.style('last_name', 'input')">
                    <div v-text="helper.feedback('last_name')"
                        :style="helper.style('last_name', 'feedback')"
                    ></div>
                </div>
            <!-- Phone -->
                <div class="form-group">
                    <label class="text-primary"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Phone:</label>
                    <input
                        type="text"
                        name="cellular"
                        placeholder="900-123-654" 
                        v-model.trim="client.cellular"
                        class="form-control form-control-sm mb-2"
                        :style="helper.style('cellular', 'input')">
                    <div v-text="helper.feedback('cellular')"
                        :style="helper.style('cellular', 'feedback')"
                    ></div>
                </div>
            </form>
        <!-- Submit Button-->
            <div class="text-center mt-3">
                <button 
                    type="button" 
                    @click.stop.prevent="onSubmit()"
                    class="btn btn-outline-primary btn-sm">
                    Submit
                </button>
            </div>
        </div>
    </div> 
</template>  


//COMPONENT
<script>

//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
import FeedBack from "../utilities/feedback_v2.js";
import Validation from "../utilities/validation.js";
// Alerts
import AlertIconFail from '../alert/icon/fail.vue';
import AlertIconSuccess from '../alert/icon/success.vue';


export default {
/*------------------------------------------------------
 | COMPONENT: New Client
 |------------------------------------------------------
 | This will serve as a small component for 
 | creating new clients via the app's api.
 |
*/


//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components:{
        'alert-fail': AlertIconFail, 
        'alert-success': AlertIconSuccess
    },
//------------------------------------------------------
// INSTANCE PROPERTIES
//------------------------------------------------------
    props:{
        view: {
            type: Boolean,
            required: false,
            default: true,
        }
    },  
//------------------------------------------------------
// REACTIVE DATA
//------------------------------------------------------
    data: function() {
        return {
            route: '/api/clients',
            client: {
                first_name: '',
                last_name: '',
                cellular: ''
            },
            show: {
                form: true,
                onFail: false,
                onSuccess: false,
            },
            helper: new FeedBack(),
            form: new Validation(),
            formData: new FormData(),  
        }
    },
//------------------------------------------------------
// INSTANCE METHODS
//------------------------------------------------------
    methods: {
        onSubmit: function(){
            if(this.validateFullForm()){
                this.storeClient();
            }
        },
    //--------------------------------------------------
	// HTTP REQUESTS
    //--------------------------------------------------
        storeClient: function(){
            let vi = this;
            axios.post(vi.route, vi.formData)
                .then( function(response){
                    vi.show.form = false;
                    vi.show.onSuccess = true;
                    setTimeout( function(){
                        vi.resetComponent();
                        vi.broadCastOnNewClient();
                    }, 1500);
                })
                .catch( function(error){
                    console.log(error.response.data.errors)
                    if(error.response.data.errors){
                        let backEnd = error.response.data.errors;
                        for(let error in backEnd){
                            console.log(error + backEnd[error]);
                            vi.helper.setStyle(error, 'input', 'invalid');
                            vi.helper.setStyle(error, 'feedback', 'invalid');
                            vi.helper.setFeedBack(error,  backEnd[error][0]);
                        }
                    }else{
                        console.log('NewClient.storeClient() Error:' + error.response);
                        vi.show.form = false;
                        vi.show.onFail = true;
                    } 
                })
        },
    //--------------------------------------------------
	// FORM VALIDATION 
    //--------------------------------------------------
        validateFullForm: function(){
            let vi = this;
            let readyStatus = true;

            for(let field in vi.client){
                if(vi.validateField(field)){
                    vi.formData.append(field, vi.client[field]);
                }else{
                    readyStatus = false
                }
            }
            return readyStatus;
        },
        validateField: function(input){
            let vi = this;
            if(vi.form.validate(input, vi.client[input])){
                return vi.isValid(input);
            }
            return vi.isInvalid(input);

        },
        isInvalid: function(field) {
			this.helper.setStyle(field, 'input', 'invalid');
			this.helper.setStyle(field, 'feedback', 'invalid');
			this.helper.setFeedBack(field, this.form.getMessage(field));
            return false;
            
		},
        isValid: function(field) {
			this.helper.setStyle(field, 'input', 'valid'); 
			this.helper.setStyle(field, 'feedback', 'valid');
			this.helper.setFeedBack(field, 'looks great!');
            return true;
            
        },
    //--------------------------------------------------
	// COMPONENT INITIALIZATION
    //--------------------------------------------------
        rules: function(){
            return {
                first_name: {
                    min: 2,
                    max: 16,
                    type: 'text',
                    required: true
                },
                last_name: {
                    min: 2,  
                    max: 15,
                    type: 'text',
                    required: true
                },
                cellular: {
                    min: 9,
                    max: 15,
                    type: 'phone',
                    required: true
                }
            }
        },
        initialize: function(){
            let vi = this;
            for(let field in vi.rules()){      
                vi.$set(vi.helper.styleFeedBacks, [field], '');
                vi.$set(vi.helper.styleInputs, [field], '');
                vi.$set(vi.helper.messages, [field], '');
            }
            vi.form.setRules(vi.rules());
        },
    //--------------------------------------------------
	// COMPONENT RESET
    //--------------------------------------------------
        resetComponent: function(){
            Object.assign(this.$data, this.$options.data());
            this.initialize(); //form validation & feedback.
        },
    //--------------------------------------------------
	// BROADCASTING TO&FROM COMPONENTS 
    //--------------------------------------------------
        broadCastOnNewClient: function(){
            let vi = this;
            Event.fire('onNewClient');
        }
    },
//------------------------------------------------------
// LYFECYCLE HOOKS
//------------------------------------------------------
    mounted: function(){
       this.initialize(); 
    } 
}
</script>

<style scoped>
    .pos-top-right{
        position: absolute;
        top: -3px;
        right: 25px;
    }
</style>
