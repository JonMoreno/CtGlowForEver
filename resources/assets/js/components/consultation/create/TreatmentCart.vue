<template>
    <div>
        <hr class="mb-1 mt-2"/>
        <!-- discount exceeds total -->
        <transition 
            name="custom-classes-transition"
            enter-active-class="animated bounceInLeft"
            leave-active-class="animated bounceOutLeft"
        >
            <alert-warning :state="view.alert_warning" class="pt-1 pb-0 mb-1">
                <span slot="alert-header">
                    Opps! 
                </span>
                <span slot="alert-body">
                The discount you are trying to apply exceeds the treatment's price.
                </span>
            </alert-warning>
        </transition> <!-- ../discount exceeds total -->

        <!-- apply discount message -->
        <transition 
            name="custom-classes-transition"
            enter-active-class="animated bounceInLeft"
            leave-active-class="animated bounceOutLeft"
        >
            <table v-if="view.current_discount" class="table table-hover table-striped table-sm  my-0 bg-light-danger">
                <thead >
                    <tr>
                        <th> Current Discount <i class="fa fa-arrow-right gfe-text-red"></i> </th>
                        <th class="gfe-text-red">
                            {{current_discount.discount_type == 'percentage'? '' : '$'}}{{current_discount.discount_value}}{{current_discount.discount_type == 'percentage'? '%' : '' }}OFF
                        </th>
                        <th class="text-right">
                            <span class="pr-1"> 
                                apply
                                <i class="fa fa-angle-double-down text-danger pr-2 fa-lg"></i>
                            </span>
                        </th>
                    </tr>
                </thead>
            </table>
        </transition><!-- ../apply discount message -->

        <!-- treatment-cart -->
        <table class="table table-hover table-striped table-sm  mb-0 bg-white">
            <tbody>
                <tr v-if="tab.treatments" v-for="(treatment, index) in tab.treatments" :key="index + Math.floor(Math.random() * Math.floor(1000))">
                    <td class="text-center width-30">
                        <a  @click="onDeleteTreatment(index)" href="#" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-trash-o fa-lg"></i>
                        </a>
                    </td>
                    <td class="width-15">
                        <i class="fa fa-cart-plus fa-lg text-success"></i> 
                    </td>
                    <td>
                        {{ treatment.name }}
                    </td>
                    <td class="text-right">
                        <span v-if="treatment.discount_type" class="gfe-text-red">
                            -{{treatment.discount_type == 'monetary'? '$' : ''}}{{treatment.discount_value}}{{treatment.discount_type == 'percentage'? '%' : ''}}OFF
                        </span>
                    </td>
                    <td class="text-right"> 
                        <span v-if="treatment.discount_value">
                            <del class="gfe-text-red">+${{ treatment.price }} </del>
                        </span>
                        <span v-else>
                            +${{ treatment.price }}
                        </span>
                    </td>
                    <transition 
                        name="custom-classes-transition"
                        enter-active-class="animated bounceInRight"
                        leave-active-class="animated bounceOutRight"
                    >
                        <td v-if="!treatment.discount_applied && view.current_discount" class="text-center width-35 px-0 py-0 bg-light-danger">
                            <input @change="applyDiscount(index , treatment.discount_applied )" v-model="treatment.discount_applied" type="checkbox" class="gfe-checkbox">
                        </td>
                    </transition>
                </tr>
            </tbody>
        </table><!-- ../treatment-cart -->        

        <!-- discounts List -->
        <div v-if="tab.treatments.length > 0" class="d-flex justify-content-end my-2">
            <div class="d-flex flex-column">
                <small class="text-right">- treatment discounts</small>

                <ul class="list-group list-group-flush bg-light-secondary pr">
                    <span v-for="(discount,index) in tab.treatments" :key="index + Math.floor(Math.random() * Math.floor(1000))">
                        <li v-if="discount.discount_applied" class="list-group-item py-0 px-1 bg-light-danger">
                            <small class="text-muted">
                                <del class="d-inline pr-2">
                                    ${{Number(discount.price).toFixed(2)}}
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </del>
                                <span> ${{discount.discount_price.toFixed(2)}} </span>
                            </small>
                        </li>
                    </span>
                </ul>
            </div>
        </div><!-- ../discounts List -->

        <!-- total-treatments-price -->
        <div v-if="tab.treatments.length > 0" class="text-right">
            <div class="d-inline px-2 py-2 bg-white rounded">
                <strong class="text-fancy-dark">Treatments:</strong>
                <span class="gfe-text-red"> ${{tab.total.toFixed(2)}} </span>
            </div>
        </div><!-- ../total-treatments-price -->
    </div>
</template>

<script type="text/javascript">

//dependencies:
window._ = require('lodash');
import AlertWarning from '../../alert/Warning.vue';

export default {
    
    components: {
        'alert-warning': AlertWarning
    },

    data: function() {
        return {
            current_discount: '',
            tab: {
                treatments: [],
                total: 0.00,
            },
            view: {
                current_discount: false,
                alert_warning: false,
                helpertext: false,
                discount: false,
                total: false
            },
            route: '/api/purchase-treatments',
            client_ref: '',
            invoice_ref: '',
            form: [],
        }
    },

    methods: {
        addToTotal: function(value) {
            let total = this.tab.total;
            this.tab.total = +total + +value;
            this.broadCastCashierPlus(value);

        },
        subtractOfTotal: function(value) {
            let total = this.tab.total;
            this.tab.total = total - value;
             this.broadCastCashierMinus(value);

        },
        applyDiscount: function(index, test) {
            let vi = this;
            if(vi.current_discount.discount_type == 'monetary') {  
                vi.applyMonetaryDiscount(index);
            }else{ 
                vi.applyPercentageDiscount(index);
            }

        },
        onAddTreatmentTest: function(treatment) {
            let index = this.tab.treatments.push(treatment) - 1;
            this.addToTotal( this.tab.treatments[index].price);
            this.view.total = true; //display treatments price.

        },
        onDeleteTreatment: function(index) {
            let vi = this;
            vi.deleteFromCashierTotal(index);
            if(vi.tab.treatments[index].discount_applied == true){
                vi.broadCastOnDiscountRemove(vi.tab.treatments[index].discount_id);
            }
            vi.tab.treatments.splice(index, 1);// remove from cart list.
               
        },
        applyDiscountProps: function(treatment) {
            let vi = this;
            let discount = vi.current_discount;
            vi.$set(treatment, 'discount_applied', true);
            vi.$set(treatment, 'discount_id', discount.id);
            vi.$set(treatment, 'discount_name', discount.name);
            vi.$set(treatment, 'discount_type', discount.discount_type);
            vi.$set(treatment, 'discount_value', discount.discount_value);   
        },
        applyMonetaryDiscount: function(index) {
            let vi = this; 
            let current_discount = vi.current_discount;
            let tab_treatment = vi.tab.treatments[index];
            
            if(Number(tab_treatment.price) >= Number(current_discount.discount_value)) {
                vi.applyDiscountProps(tab_treatment); //apply discount props to tab treatment.
                vi.subtractOfTotal(tab_treatment.price); //subtract original treatment price.
                let discounted_treatment = tab_treatment.price - current_discount.discount_value;//apply discount to treatment.
                vi.$set(tab_treatment, 'discount_price', discounted_treatment); //add discount prop to treatment.
                vi.addToTotal(discounted_treatment);//add to total discounted treatment.
                vi.view.current_discount = false; //hide discount apply checkbox.
                vi.broadCastOnDiscountApplied(tab_treatment);

            }else {
                vi.$set(tab_treatment, 'discount_applied', false);
                vi.view.alert_warning = true;
                vi.delayAlertWarningOff();
            }

        },
        applyPercentageDiscount: function(index) {
            let vi = this;
            let discount = vi.current_discount;
            let treatment = vi.tab.treatments[index];
            let discount_amount = (discount.discount_value / 100) * treatment.price;

            if(Number(treatment.price) >= Number(discount_amount) ){
                vi.applyDiscountProps(treatment); //apply discount props to tab treatment.
                vi.subtractOfTotal(treatment.price); //subtract original treatment price.
                let discount_price = treatment.price - discount_amount;//apply discount to treatment.
                //vi.$set(treatment, 'discount_amount', discount_amount);
                vi.$set(treatment, 'discount_price', discount_price); //add discount prop to treatment.
                vi.addToTotal(discount_price);//add to total discounted treatment.
                vi.view.current_discount = false; //hide discount apply checkbox.
                vi.broadCastOnDiscountApplied(treatment);
            }else{
                vi.$set(treatment, 'discount_applied', false);
                vi.view.alert_warning = true;
                vi.delayAlertWarningOff();
            }

        },
        deleteFromCashierTotal: function(index) {
            let vi = this;
            if(this.tab.treatments[index].discount_value > 0) {               
                vi.subtractOfTotal(vi.tab.treatments[index].discount_price);
            }else{ 
                vi.subtractOfTotal(vi.tab.treatments[index].price);
            }

        },
    //events.
        broadCastCashierPlus: function(amount) {
            let num = 0;
            num++;
            Event.fire('onCashierPlus', amount);
            
        },
        broadCastCashierMinus: function(amount) {
            Event.fire('onCashierMinus', amount);

        },
        listenOrRemoveCurrentDiscount: function() {
            let vi =  this;
            Event.listen('onRemoveCurrentDiscount', function(ref) {
                if(vi.current_discount.id == ref){
                    vi.current_discount = '';
                    vi.view.current_discount = false;
                }
            });

        },
        listenOnCloseAlertWarning: function() {
            let vi = this;
            Event.listen('onCloseAlertWarning', function() {
               vi.view.alert_warning = false;
            });

        },
        listenOnAddTreatment: function() {
			let vi = this;
			Event.listen('onAddTreatment', function(treatment) {
                let num = 0;
                num++;
                vi.onAddTreatmentTest(treatment);
            });

        },
        listenOnDiscount: function() {
            let vi = this;
            Event.listen('onDiscount', function(discountCart) {
                if(discountCart.service == 'treatment'){
                    vi.current_discount = {};
                    vi.view.current_discount = true;
                    vi.current_discount = discountCart.discount; 
                }else{
                    vi.view.current_discount = false;
                }
            });

        },	
        broadCastOnDiscountApplied: function(discounted_treatment) {
            let references = {
                'service': 'treatment',
                'service_id': discounted_treatment.id,
                'service_original_price': discounted_treatment.price,
                'service_discount_id': discounted_treatment.discount_id
            }
            Event.fire('onDiscountApplied', references);// DiscountCart.vue

        },
        broadCastOnDiscountRemove: function(discount_ref) {
            Event.fire('onDiscountRemove', discount_ref);

        },
        delayAlertWarningOff: _.debounce( function() {
            this.view.alert_warning = false;

        }, 10000),
    //form events.
        storePurchaseTreatment: function(pointer) {
            let vi = this;

            axios.post(vi.route, vi.form[pointer])
                .then( function(response) {
                    Event.fire('onTreatmentError', false);
                })
                .catch( function(error) {
                    console.log('TreatmentCart.storePurchaseTreatment() Error' + error);
                    Event.fire('onTreatmentError', true);
                }); 
            if(pointer == (vi.tab.treatments.length - 1) ){
                vi.resetComponent();
            }  
        },
        appendPurchaseTreatment: function() {
            let vi = this;
            let treatments  = vi.tab.treatments;
            let size = vi.tab.treatments.length;
                if(size > 0){
                    let i;
                    let obj;
                    for(i = 0; i < size; i++) {
                        let prop;
                        obj = null;
                        obj = new FormData();
                        for(prop in treatments[i]) {
                            if(prop == 'id') {
                                obj.append('client_id', vi.client_ref);
                                obj.append('invoice_id', vi.invoice_ref);
                                obj.append('treatment_id', [treatments[i][prop]]);
                            }else if(prop == 'price') {
                                obj.append('sold_price', [treatments[i][prop]]);
                            }
                        }
                        vi.form.push(obj);
                        vi.storePurchaseTreatment(i);
                    }
                }

        },
        listenOnInvoice: function() {
            let vi = this;
            Event.listen('onInvoice', function(ref){
                vi.client_ref = ref.client;
                vi.invoice_ref = ref.invoice;
                vi.appendPurchaseTreatment();
            });

        },
   //component settings.
        resetComponent () {
            Object.assign(this.$data, this.$options.data());
            
        },
        listenOnResetComponent: function() {
            let vi = this;
            Event.listen('onResetComponent', function() {
                vi.resetComponent();
            });
        },
    },

    created: function() {
        this.listenOrRemoveCurrentDiscount();
        this.listenOnCloseAlertWarning();
        this.listenOnResetComponent();
        this.listenOnAddTreatment();
        this.listenOnDiscount();
        this.listenOnInvoice();

    }
}
</script>

<style scoped>

.gfe-checkbox {
    width: 25px !important; 
    height: 30px !important;
}
.caret{
    display:none
}
</style>
