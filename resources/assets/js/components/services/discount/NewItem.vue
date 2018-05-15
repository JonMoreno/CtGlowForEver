//COMPONENT TEMPLATE
<template>
    <div>
    <!-- NEW ITEM BUTTON -->
        <div class="col-12 pr-0 mb-2 text-right">
            <button 
                type="button" 
                @click.stop.prevent="view.show = !view.show"
                class="btn btn-light btn-sm text-primary mt-1">
                <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> New Discount
            </button>
        </div>
    <!-- NEW ITEM FORM -->
        <transition name="slide-fade">
            <div v-if="view.show" :class="{'bg-light-secondary': !view.show}" class="list-group-item px-2 mb-5 rounded">
                <form @keyup="processInput($event.target.name)" class="form-row mx-auto pt-3">
                <!-- NAME -->
                    <div :class="[view.btnSave? 'col-12 col-sm-6' : 'col-12 col-sm-6' ]" class="text-center">
                    <!-- INPUT -->
                        <input 
                            name="name" 
                            type="text" 
                            v-model.trim="form.name"
                            class="form-control" 
                            placeholder="discount name"
                            :style="helper.style('name','input')">
                    <!-- HELPER TEXT -->
                        <div 
                            class="mt-0"
                            v-text="helper.feedback('name')"
                            :style="helper.style('name','feedback')">
                        </div>
                    </div>
                <!-- DISCOUNT VALUE -->
                    <div :class="[view.btnSave? 'col-12 col-sm-5' : 'col-12 col-sm-6' ]" class="text-center">
                    <!-- INPUT -->
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button 
                                    :class="{ active: discount.monetary}"
                                    @click="applyDicountType('monetary')" 
                                    class="btn btn-outline-secondary font-weight-bold">$</button>
                                <button 
                                    :class="{ active: discount.percentage}"
                                    @click="applyDicountType('percentage')"
                                    class="btn btn-outline-secondary font-weight-bold no-right-radius">%</button>
                            </div>
                            <input 
                                type="text" 
                                class="form-control"
                                name="discount_value" 
                                placeholder="discount value"
                                v-model.trim="form.discount_value"
                                :class="[discount.monetary || discount.percentage ? '' : 'disabled']"
                                :style="helper.style('discount_value','input')">
                            <div class='input-group-append'>
                                <span class="input-group-text">OFF</span>
                            </div>
                        </div>
                    <!-- HELPER TEXT -->
                        <div 
                            class="mt-0"
                            v-text="helper.feedback('discount_value')" 
                            :style="helper.style('discount_value','feedback')">
                        </div>
                    </div>
                <!-- SAVE BUTTON -->
                    <transition name="slide-fade">
                        <div v-if="view.btnSave" class="col-12 col-sm-1 px-0">
                            <button
                                type="button" 
                                class="btn btn-primary px-2"
                                @click.stop.prevent="store()">
                                Add
                            </button>
                        </div>
                    </transition>
                </form>
            </div>
        </transition>
    <!-- ALERT FAIL -->
        <transition name="bounce">
            <alert-fail :state="view.alert"></alert-fail>
        </transition>
    </div>
</template>

//COMPONENT
<script>

//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
window._ = require('lodash');
import AlertIconFail from '../../alert/icon/fail.vue';
import Feedback from '../../utilities/feedback_v2.js';
import Validation from '../../utilities/validation.js';

export default {
/*------------------------------------------------------
| COMPONENT: New Item 
|-------------------------------------------------------
| This component will handle treatments:
|   - new items
|
*/

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components: {
        'alert-fail': AlertIconFail
    },
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function() {
        return {
            discount_type: '',
            form: {
                name: '',
                discount_value: '',
            },
            view: {
                show: false,
                alert: false,
                btnSave: false,
            },
            discount:{
                monetary: false,
                percentage: false,
            },
            helper: new Feedback(),
            validation: new Validation()
        }
    },
//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
    methods: {
        applyDicountType: function(val) {
            if(val == 'monetary'){
                this.discount.monetary = true;
                this.discount.percentage = false;
                this.discount_type = 'monetary';
            }else if(val == 'percentage'){
                this.discount.monetary = false;
                this.discount.percentage = true;
                this.discount_type = 'percentage';
            }
        },
    //--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
        store: function() {
            let vi = this;
            if(vi.validateForm()){
                axios.post('/api/discounts', 
                    {   name: vi.form.name,
                        discount_type: vi.discount_type,
                        discount_value: vi.form.discount_value,
                    })
                    .then( function(response) {
                        Event.fire('onAddItem', response.data);//DISCOUNTLIST.created()
                        //clear out input fields.
                        vi.form.name = '';
                        vi.form.discount_value = '';
                    })
                    .catch( function(error) {
                        if(error.response.data.errors){
                            for(let field in error.response.data.errors){
                                vi.helper.setStyle(field, 'input', 'invalid');
                                vi.helper.setStyle(field, 'feedback', 'invalid');
                                vi.helper.setFeedBack(field, error.response.data.errors[field][0]);
                            }
                        }else{
                            //display alert fail component.
                            vi.view.alert = true;
                            console.log("NewItem.store() Error:"+error.response);
                        }
                    });
            }
        },
    //--------------------------------------------------
	// FORM METHODS & EVENTS
	//--------------------------------------------------
		validateForm: function() {
            let vi = this;
            let status = true;
            for(let field in vi.form){
                if(!vi.validation.validate(field, vi.form[field])){
                    status = false;
                }
            }
            return status;
        },
        processInput: _.debounce( function(field) {
            let vi = this;
            if(vi.validation.validate(field, vi.form[field])){
                if(vi.validateForm() == true) {
                    setTimeout( function() {
                        vi.view.btnSave = true 
                    },500);
                }
                return vi.isValid(field);
            }else{
                return vi.isInvalid(field);
            }
        }, 800),
        isInvalid: function(field) {
			this.helper.setStyle(field, 'input', 'invalid');
			this.helper.setStyle(field, 'feedback', 'invalid');
			this.helper.setFeedBack(field, this.validation.getMessage(field));
			return false;
			
		},
        isValid: function(field) {
			this.helper.setStyle(field, 'input', 'valid'); 
			this.helper.setStyle(field, 'feedback', 'valid');
			this.helper.setFeedBack(field, 'looks great!');
			return true;
		},
        rules: function() {
            return {
                name: {
                    min: 2,
                    max: 150,
                    type: 'text',
                    required: true,
                },
                discount_value: {
                    min: 1,
                    max: 10,
                    type: 'number',
                    required: true,
                },
            }
        },
    //--------------------------------------------------
	// INTIATION METHODS
	//--------------------------------------------------
        initialize: function() {
            let vi = this;
            let fields = vi.form;
            //initialize feedback reactive data.
            for(let field in fields){
                vi.$set(vi.helper.styleFeedBacks, field, '');
                vi.$set(vi.helper.styleInputs, field, '');
                vi.$set(vi.helper.messages, field, '');
            }
            //initialize form validation rules.
            vi.validation.setRules(vi.rules());
        }
    },
//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
    mounted: function() {
        this.initialize();
    }
}
</script>

//COMPONENT STYLING
<style scoped>
    .height-60{
        height: 60px;
    }
    .no-right-radius{
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }
</style>

