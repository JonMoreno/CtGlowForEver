// COMPONENT TEMPLATE
<template>
    <a  
        @click="select()"
        :class="{active: item.selected}"
        class="list-group-item list-group-item-action flex-column align-items-start py-1"> 

    <!-- ALERT FAIL -->
        <transition name="bounce">
            <alert-failure :state="view.alertFail"></alert-failure>
        </transition>

    <!-- DID BADGE -->
        <div class="clearfix mt-1">
            <div class="pull-left">
                <span :class="[item.selected? 'badge badge-light' : 'badge gfe-bg-lred text-white']" class="font-weight-bold">
                    DID:{{item.id}}
                </span>
            </div>
        </div>

    <!-- ITEM FLEX GRID -->
        <div v-if="!view.alertFail" class="d-flex justify-content-between">
        <!-- ITEM NAME -->
            <h5 :class="{'text-white pt-3': item.selected}" class="w-300">
            <!-- HELPER TEXT -->
                <div 
                    v-text="helper.feedback('name')"
                    class="text-white text-center mt-0 h-20"
                    :style="helper.style('name','feedback')">
                </div>
            <!-- INPUT -->
                <div v-if="item.selected" class="input-group mb-3 mt-0">
                    <textarea 
                        rows="2"
                        type="text" 
                        name="name"
                        v-model.trim="item.name"
                        @click="applyCaret('name')"
                        @blur="onEdit.name = false"
                        @keyup="processInput('name')" 
                        :style="helper.style('name','input')"
                        class="form-control form-control-sm mt-1">
                    </textarea>
                </div>
            <!-- VALUE -->
                <span class="d-inline-block pl-2 text-capitalize">
                    {{ item.name }}
                    <span v-show="onEdit.name">
                        <i aria-hidden="true" class="fa fa-caret-left fa-lg text-warning"></i>
                        <hr class="mb-0 mt-1 p05 bg-warning"/>
                    </span>
                </span>
            </h5>
        <!-- ITEM DISCOUNT VALUE -->
            <div :class="[item.selected ? 'text-white pt-3': 'gfe-text-red']" class="lead w-200">
            <!-- HELPER TEXT -->
                <div 
                    v-text="helper.feedback('discount_value')" 
                    class="text-white text-center mt-0 h-20"
                    :style="helper.style('discount_value','feedback')">
                </div>
            <!-- INPUT -->
                <div v-if="item.selected" class="input-group mb-3 ">
                    <div class="input-group-prepend bg-light rounded">
                        <button 
                            :class="{ active: discount.monetary}"
                            @click="applyDicountType('monetary', true)" 
                            class="btn btn-outline-danger btn-sm">$</button>
                        <button 
                            :class="{ active: discount.percentage}"
                            @click="applyDicountType('percentage', true)"
                            class="btn btn-outline-danger btn-sm">%</button>
                    </div>

                    <input 
                        type="text" 
                        name="discount_value"
                        v-model.trim="item.discount_value"
                        @click="applyCaret('discount_value')"
                        @blur="onEdit.discount_value = false"
                        @keyup="processInput('discount_value')"
                        :style="helper.style('discount_value','input')"
                        class="form-control form-control-sm border-left-0 border-right-0">
                    <div class='input-group-append bg-light-danger text-red'>
                        <span class="input-group-text">OFF</span>
                    </div>
                </div>
            <!-- VALUE -->
                <div class="text-center">
                    <span v-if="item.discount_type == 'monetary'">
                        - <i class="fa fa-usd"></i>{{Number(item.discount_value).toFixed(2) }} OFF
                    </span>
                    <span v-else>
                        - <i class="fa fa-percent"></i>{{item.discount_value }} OFF
                    </span>
                    <span v-show="onEdit.discount_value">
                        <i aria-hidden="true" class="fa fa-caret-left fa-lg text-warning"></i>
                        <hr class="mb-0 mt-1 p05 bg-warning"/>
                    </span>
                </div> 
            </div> 
        </div>

        <div :class="{'mt-3 ': item.selected}" class="clearfix">
        <!-- LAST UPDATED -->
            <div class="pull-left">
                <small :class="[item.selected ? 'text-white': 'text-muted']">
                    Last updated {{item.updated_at}}
                </small>
            </div>
        <!-- ITEM SETTINGS -->
            <div v-if="item.selected" class="pull-right px-2">
                <button @click.stop.prevent="destroy(index)" type="button" class="btn btn-light btn-sm">
                    <i class="fa fa-times-circle"></i> remove
                </button>
            </div>
        </div>
    </a>
</template>


<script type="text/javascript">

let timeout = 0;
//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
window._ = require('lodash');
import Feedback from '../../utilities/feedback_v2.js';
import AlertIconFail from '../../alert/icon/fail.vue';
import Validation from '../../utilities/validation.js';

export default {
/*------------------------------------------------------
| COMPONENT: LIST ITEM
|-------------------------------------------------------
| This component will handle treatment:
|   - Single Display
|
*/

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components: {
        'alert-failure': AlertIconFail
    },

//------------------------------------------------------
// COMPONENT PROPS
//------------------------------------------------------
    props: {
        item: {
            type: [Object],
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function() {
        return {
            onEdit: {
                name: false,
                discounted_value: false,
            },
            view: {
                alertFail: false,
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
    //--------------------------------------------------
	// DATA MANIPULATION
	//--------------------------------------------------
        applyDicountType: function(val , withRequest = false) {
            if(val == 'monetary'){
                this.discount.monetary = true;
                this.discount.percentage = false;
                this.item.discount_type = 'monetary';
                withRequest ? this.update('discount_type') : '';
            }else if(val == 'percentage'){
                this.discount.monetary = false;
                this.discount.percentage = true;
                this.item.discount_type = 'percentage';
                withRequest ? this.update('discount_type') : '';
            }
        },
    //--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
        update: function(field) {
            let vi = this;
            axios.patch('/api/discounts/'+ vi.item.id,
                {
                    [field]: vi.item[field],
                })
                .then( function(response){
                    vi.item.updated_at = response.data;
                })
                .catch( function(error){
                    if(error.response.data.errors){
                        for(let field in error.response.data.errors){
                            vi.helper.setStyle(field, 'input', 'invalid');
                            vi.helper.setStyle(field, 'feedback', 'invalid');
                            vi.helper.setFeedBack(field, error.response.data.errors[field][0]);
                        }
                    }else{
                        //display alert fail component.
                        vi.view.alertFail = true;
                        console.log("ListItem.update() Error:"+error.response);
                    }
                })
        },
        destroy: function(index) {
            let vi = this;
            
            axios.delete('/api/discounts/' + vi.item.id)
                .then( function(response){
                    Event.fire('onRemoveListItem', index); //DiscountList.created()
                })
                .catch( function(error){
                    //display alert fail component.
                    vi.view.alertFail = true;
                    console.log("ListItem.destroy() Error:"+ error.response);
                });    

        },
    //--------------------------------------------------
	// FORM EVENT & HANDLING
	//--------------------------------------------------
        applyCaret: function(select) {
            this.onEdit[select] = true;
            for(let field in this.onEdit){
                if(field != select){
                    this.onEdit[field] = false;
                }
            }
        },
        processInput: _.debounce( function(field) {
            console.log(this.item[field]);
            let vi = this;
            if(vi.validation.validate(field, vi.item[field])){
                vi.item.status = true;
                vi.isValid(field);
                vi.update(field);

            }else{
                vi.item.status = false;
                vi.isInvalid(field);
            }
        }, 1000),
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
                    max: 100,
                    type: 'text',
                    required: true,
                },
                discount_value: {
                    min: 2,
                    max: 10,
                    type: 'number',
                    required: true,
                }
            }
        },
    //--------------------------------------------------
	// COMPONENT BROADCASTING EVENTS
	//--------------------------------------------------
        select: function() {
            Event.fire('onSelectItem', this.index); //DiscountList.created()
        },
    
        unSelect: function() {
            Event.fire('onSelectItem', null); //DiscountList.created()
        },
     //--------------------------------------------------
	// INITIALZE DATA
	//--------------------------------------------------
        initialize: function() {
            let vi = this;
            let fields = vi.item;
            //initialize feedback reactive data.
            for(let field in fields){
                vi.$set(vi.helper.styleFeedBacks, field, '');
                vi.$set(vi.helper.styleInputs, field, '');
                vi.$set(vi.helper.messages, field, '');
            }
            //initialize form validation rules.
            vi. validation.setRules(vi.rules());
        }
    },
//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
    created: function() {
        this.initialize(); 
        this.applyDicountType(this.item.discount_type);
    }
}
</script>

//COMPONENT STYLING
<style scoped>

    .w-200{
        width: 200px !important;
    }
    .w-300{
        width: 300px !important;
    }
    .h-20{
        min-height: 20px;
    }
    .p05{
        padding: 1px !important;
    }
    .left-border{
        border-left: 2px solid #eee;
    }
    .borderl-none{
        border-left: none;
    }
    .no-right-radius{
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    .position-top {
        position: relative;
        right: 0px;
        top: 0px;
        margin-bottom: 5px;
    }
</style>


