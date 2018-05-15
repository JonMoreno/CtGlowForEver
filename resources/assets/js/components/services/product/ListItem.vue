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

    <!-- DISCONTINUE ALERT BADGE -->
        <div class="clearfix mt-1">
            <div class="pull-left">
                <span :class="[item.selected?'badge badge-light' : 'badge gfe-bg-lred text-white']" class="font-weight-bold">
                    PID:{{item.id}}
                </span>
            </div>
            <div class="pull-right">
                <button 
                    type="button"
                    :id="discontinue"
                    v-if="item.discontinue"
                    data-placement="top" data-html="true"
                    class="badge badge-pill badge-warning"
                    title="If an item is discontinued it will not show up on your consultation services"
                >
                    Discontinued
                </button>
            </div>
        </div>

    <!-- ITEM FLEX GRID -->
        <div v-if="!view.alertFail" class="d-flex justify-content-between">
        <!-- ITEM NAME -->
            <h5 :class="{'text-white pt-3': item.selected}" class="w-275">
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
                    <del v-if="item.discontinue">  {{ item.name }}</del>
                    <span v-else>  {{ item.name }}</span>

                    <span v-show="onEdit.name">
                        <i aria-hidden="true" class="fa fa-caret-left fa-lg text-warning"></i>
                        <hr class="mb-0 mt-1 p05 bg-warning"/>
                    </span>
                </span>
            </h5>
        <!-- ITEM PRICE -->
            <span :class="[item.selected ? 'text-white pt-3': 'text-success']" class="lead w-115">
            <!-- HELPER TEXT -->
                <div 
                    v-text="helper.feedback('price')" 
                    class="text-white text-center mt-0 h-20"
                    :style="helper.style('price','feedback')">
                </div>
            <!-- INPUT -->
                <div v-if="item.selected" class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white"><i class="fa fa-money text-success" aria-hidden="true"></i></span>
                    </div>
                    <input 
                        type="text" 
                        name="price"
                        v-model.trim="item.price"
                        @click="applyCaret('price')"
                        @blur="onEdit.price = false"
                        @keyup="processInput('price')"
                        :style="helper.style('price','input')"
                        class="form-control form-control-sm" 
                    >
                </div>
            <!-- VALUE -->
                <span class="d-inline-block pl-2">
                    <i class="fa fa-money"></i>
                    {{ Number(item.price).toFixed(2) }} 
                    <span v-show="onEdit.price">
                        <i aria-hidden="true" class="fa fa-caret-left fa-lg text-warning"></i>
                        <hr class="mb-0 mt-1 p05 bg-warning"/>
                    </span>
                </span> 
            </span> 
        </div>
    <!-- ITEM QUANTITY -->
        <div class="text-right">
        <!-- VALUE -->
            <div :class="{'text-white pr-2': item.selected}">
                QTY: <span class="font-weight-bold">#{{item.quantity }}</span>
                <span v-show="onEdit.quantity">
                    <i aria-hidden="true" class="fa fa-caret-left fa-lg text-danger"></i>
                    <hr class="my-0 pt-1 bg-danger"/>
                </span>
            </div>
        <!-- INPUT -->
            <div v-if="item.selected" class="btn-group d-inline pr-3">
                <button @click="inventory(-1)" type="button" class="btn btn-light btn-sm rounded py-0 px-0">
                    <i class="fa fa-minus-circle fa-lg text-danger"></i>
                </button>
                <button @click="inventory(+1)" type="button" class="btn btn-light btn-sm rounded py-0 px-0">
                    <i class="fa fa-plus-circle fa-lg text-primary"></i>
                </button>
            </div>
        <!-- HELPER TEXT -->
            <div>
                <span v-if="item.quantity <= 0" class="badge badge-pill badge-danger">
                    Out of stock
                </span>
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
                <button @click.stop.prevent="onDiscontinue()" type="button" class="btn btn-light btn-sm"> 
                    <i class="fa fa-ban"></i> 
                    <span v-if="!item.discontinue">discontinue</span>
                    <span v-else>continue</span>
                </button>
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
| This component will handle product:
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
// COMPUTED PROPERTIES
//------------------------------------------------------  
    computed:{
        discontinue: function() {
            return 'discontinue'+this.item.id;
        }
    },
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function() {
        return {
            onEdit: {
                name: false,
                price: false,
                quantity: false,
            },
            view: {
                alertFail: false,
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
	// DATA MUTATION
	//--------------------------------------------------
        inventory: function(val) {
            let vi = this;
            let inventory = Number(vi.item.quantity);
            vi.item.quantity = inventory + val;
            vi.item.quantity <= 0 ? vi.item.quantity = 0 : '';
            clearTimeout(timeout);
            timeout = setTimeout( function(){
                console.log('helo;');
                vi.update('quantity'); 
            },800);
                
        },
    //--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
        update: function(field) {
            let vi = this;
            axios.patch('/api/products/'+ vi.item.id,
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
            
            axios.delete('/api/products/' + vi.item.id)
                .then( function(response){
                    Event.fire('onRemoveListItem', index);//ProductList
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
        onDiscontinue: function() {
            this.item.discontinue = !this.item.discontinue;
            this.update('discontinue');
        },
        processInput: _.debounce( function(field) {
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
                price: {
                    min: 2,
                    max: 10,
                    type: 'price',
                    required: true,
                },
                quantity: {
                    min: 1,
                    max: 3,
                    type: 'number',
                    required: false,
                },
                discontinue: {
                    min: 1,
                    max: 6,
                    type: 'boolean',
                    required: false,
                }

            }
        },
    //--------------------------------------------------
	// COMPONENT BROADCASTING EVENTS
	//--------------------------------------------------
        select: function() {
            Event.fire('onSelectProduct', this.index); // ProductList.created()
        },
    
        unSelect: function() {
            Event.fire('onSelectProduct', null); // ProductList.created()
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

        let ref = this.item.id;
        $(function() { //enable tooltip
            $('#discontinue'+ref).tooltip();
        }); 
    }
}
</script>

//COMPONENT STYLING
<style scoped>
    .w-275{
        max-width: 275px !important;
    }
    .w-115{
        max-width: 115px !important;
    }
    .h-20{
        min-height: 20px;
    }
    .p05{
        padding: 1px !important;
    }
    .position-top {
        position: relative;
        right: 0px;
        top: 0px;
        margin-bottom: 5px;
    }
</style>


