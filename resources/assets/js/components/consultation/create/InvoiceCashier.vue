<template>
    <!-- card -->
    <div class="card border-light-secondary">
        <!-- card-body -->
        <div class="card-body pb-2">
            <!-- legend-padding -->
            <div class="mt-2 px-2">
                <!-- services-title -->
                <legend class="text-primary h5 ls-1" @click="show.view = !show.view"> 
                    <span class="cursor-pointer">
                        <i class="fa fa fa-cart-arrow-down fa-lg text-primary" aria-hidden="true"></i>
                            Services
                        <i class="fa fa-caret-down text-primary" aria-hidden="true"></i>
                    </span>
                    <hr class="mt-1"/>
                </legend>

                <!-- alert-fail-or-success-icons -->
                <span v-if="show.view">
                    <!-- alert-icon-success-form-->
                    <transition name="fade">
                        <alert-icon-success :state="show.form_success && !show.form_failed" class="no-border">
                            <div>
                                <h4>Great!</h4>
                                <p class="lh-1">Your service
                                    <br/>details have been saved!
                                </p>
                            </div>
                        </alert-icon-success>
                    </transition><!-- ../alert-icon-success-form-->

                    <!-- alert-icon-danger-form-->
                    <transition name="fade">
                        <alert-icon-fail :state="show.form_failed && !show.form_success" class="no-border"> </alert-icon-fail>
                    </transition><!-- ../alert-icon-success-form-->
                </span>
                
                <!-- services -->
                <transition name="fade">
                    <span v-show="show.view">
                        <span v-show="show.services">
                            <!-- services-treatment-tab -->
                            <treatment-tab>
                                <treatment-list></treatment-list>
                                <treatment-cart></treatment-cart>
                            </treatment-tab>

                            <!-- services-product-tab -->
                            <product-tab>
                                <product-list></product-list>
                                <product-cart></product-cart>
                            </product-tab>

                            <!-- services-discount-tab -->
                            <discount-tab>
                                <discount-list></discount-list>
                                <discount-cart></discount-cart>
                            </discount-tab>
                        </span>
                    </span>
                </transition>
            </div> <!-- ../legend padding -->	

            <!-- exceeds-total-alert-warning -->
            <transition 
                name="custom-classes-transition"
                enter-active-class="animated wobble"
                leave-active-class="animated fadeOut">

                <alert-warning :state="show.alert_warning" class="pt-1 pb-0 mb-1">
                    <span slot="alert-header">
                        Opps! This can't happen!
                    </span>
                    <span slot="alert-body">
                    The discount you are trying to apply exceeds the total price.
                    <br/>
                    Would you instead like to owe money???
                    </span>
                </alert-warning>
            </transition><!-- ../total-exceeds-alert-warning-->

            <!-- apply-discount-once-alert-danger-->
            <transition 
                name="custom-classes-transition"
                enter-active-class="animated wobble"
                leave-active-class="animated fadeOut">

                <alert-danger :state="show.alert_danger " class="pt-1 pb-0 mb-1">
                    <span slot="alert-header">
                        Opps! This can't happen!
                    </span>
                    <span slot="alert-body">
                    You can only apply one discount to the total price.
                    </span>
                </alert-danger>
            </transition><!-- ../total-apply-discount-once-alert-danger-->

            <!-- total-discount-list -->
            <div v-if="cashier.discounts.length > 0 && show.services" class="d-flex justify-content-end my-2">
                <div class="d-flex flex-column pr-3">
                    <small class="text-right pr-2">- total discount</small>									
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr v-for="(discount, index) in cashier.discounts" :key="discount.id" scope="row">
                                <td class="text-muted bg-light-danger">
                                    -{{discount.discount_type == 'monetary'? '$' : ''}}{{discount.discount_value}}{{discount.discount_type == 'percentage'? '%' : ''}}OFF
                                </td>
                                <td class="text-muted bg-light-danger">
                                    <del>${{discount.original_total.toFixed(2)}}</del>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </td>
                                <td class="text-muted bg-light-danger">
                                    ${{discount.discount_price.toFixed(2)}}
                                </td>
                                <td class="text-muted bg-light-danger">
                                    <a  @click="onRemoveDiscount(index)" href="#" class="btn btn-outline-danger btn-sm px-1 py-0">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- ../total-discount-list -->

            <!-- total-services-amount -->
            <transition 
                name="custom-classes-transition"
                enter-active-class="animated fadeInUp"
                leave-active-class="animated fadeOutDown">
                <div v-if="cashierTotal > 0 && !show.form_failed" class="text-right mt-0 pb-0 pr-2">
                    <div class="d-inline px-3 py-2">
                        <strong class="h5 text-fancy-dark">Total Amount:</strong>
                        <span class="h5 gfe-text-red"> ${{cashierTotal.toFixed(2)}} </span>
                    </div>
                </div>
            </transition>

            <!-- ready-to-pay-link -->
            <div v-if="cashierTotal > 0 && show.services" class="text-right">
                <a @click.stop.prevent="show.pay_method = !show.pay_method" class="d-block pr-2 pt-0 pb-0" href="#"> ready to pay? </a>
            </div>        

            <!-- cash-or-card-buttons -->
            <transition 
                name="custom-classes-transition"
                enter-active-class="animated fadeInUp"
                leave-active-class="animated fadeOutDown">

                <div class="text-center mb-4 px-5" v-if="show.pay_method && cashierTotal > 0">
                <hr/>
                    <button  @click.stop.prevent="togglePayMethod('cash_method')"
                        type="button" class="btn btn-light border-light-secondary py-1 px-3 mr-3">
                        <i class="fa fa-money fa-2x text-success" aria-hidden="true"></i>
                        <small class="d-block"> Cash </small>
                    </button>
                    <button @click.stop.prevent="togglePayMethod('card_method')"
                        type="button" class="btn btn-light border-light-secondary py-1 px-3 ml-3">
                        <i class="fa fa-credit-card-alt fa-2x text-info" aria-hidden="true"></i>
                        <small class="d-block "> Card </small>
                    </button>
                <hr/>
                </div>
            </transition>

            <!-- cash-option -->
            <transition name="fade">
                <div class="text-center px-5 mb-3" v-if="show.cash_method && show.pay_method && cashierTotal > 0">
                    <small class="d-block text-muted">
                        Please, calculate the cash that needs to be given back to the client.
                    </small>
                    <table class="d-inline table table-sm table-striped">
                        <tr>
                            <th class="text-center"> Cash Received: </th>
                            <td class=""> 
                                <div class="input-group input-group-sm">
                                    <div class="input-group-addon">
                                        <i class="fa fa-usd text-success" aria-hidden="true"></i>
                                    </div>
                                    <input style="max-width: 100px" type="text" name="cash_received" class="form-control text-success" v-model="cash_received">
                                </div>                            
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center"> Total Amount: </th>
                            <td class="text-center gfe-text-red">  
                                ${{cashierTotal.toFixed(2)}}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center"> Cash Back: </th>
                            <td class="text-center" :class="[cashBack > 0 ? 'bg-success rounded' : '']"> 
                                <span v-if="cashBack > 0" class="text-white">
                                    ${{cashBack.toFixed(2)}}
                                </span>
                                <span v-else>
                                    $ 0.00
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </transition>

            <!-- card-option -->
            <transition name="fade">
                <div class="text-center" v-if="show.card_method && show.pay_method && cashierTotal > 0">
                    <p class="text-muted">
                        Sorry, at this time this method of payment is not supported.
                        <br/>
                        <small>However, go ahead and pay to save record.</small>
                    </p>
                </div>
            </transition>

        </div><!-- ../card-body -->
        
        <!-- submit-pay-->
        <transition 
            name="custom-classes-transition"
            enter-active-class="animated fadeInUp"
            leave-active-class="animated fadeOutDown">
            <!-- card-footer -->
            <div v-if="show.submit_pay && cashierTotal > 0 && show.pay_method && show.cash_method || show.card_method" class="card-footer text-center bordert-light-secondary">
                <!-- services-pay-button -->
                <button @click.stop.prevent="broadCastOnSubmit()" :class="{'disabled rounded btn-light': show.on_submit}" type="button" class="btn rounded-circle btn-success px-4 pay-border">
                    <span v-if="show.on_submit">
                        <small class="d-block">Processing...</small>
                    </span>
                    <span v-else>
                        <i class="d-block fa fa-usd fa-2x"></i>
                        <small class="d-block"> Pay </small>
                    </span>
                </button>
            </div>
        </transition>
        
    </div><!-- ../card-->
</template>


<script type="text-javscript">

//dependencies.
window._ = require('lodash');
import lodash from 'lodash';

import AlertIconFail from '../../alert/icon/fail.vue';
import AlertIconSuccess from '../../alert/icon/success.vue';

import AlertWarning from '../../alert/Warning.vue';
import AlertDanger from '../../alert/Danger.vue';

import ProductTab from './ProductTab.vue';
import ProductCart from './ProductCart.vue';
import ProductList from './ProductList.vue';

import DiscountTab from './DiscountTab.vue';
import DiscountCart from './DiscountCart.vue'
import DiscountList from './DiscountList.vue';

import TreatmentTab from './TreatmentTab.vue';
import TreatmentCart from './TreatmentCart.vue';
import TreatmentList from './TreatmentList.vue';


export default {
	components: {
        'alert-warning': AlertWarning,
        'alert-danger': AlertDanger,
        
        'alert-icon-fail': AlertIconFail,
        'alert-icon-success': AlertIconSuccess,

		'product-tab': ProductTab,
		'product-list': ProductList,
		'product-cart': ProductCart,

		'discount-tab': DiscountTab,
		'discount-list': DiscountList,
		'discount-cart': DiscountCart,

		'treatment-tab': TreatmentTab,
		'treatment-cart': TreatmentCart,
        'treatment-list': TreatmentList,
        		
    },

    props: {
        reference: {
            default: '',
            required: true,
            type: [String, Object,Number],
        }

    },

    computed: {
        cashBack: function() {
            return Number(this.cash_received) - Number(this.cashierTotal);
        },
    },
    
    data: function() {
        return {
            show: {
                view: false,
                services: true,
                on_submit: false,
                submit_pay: false,
                form_failed: false,
                form_success: false,
                pay_method: false,
                cash_method: false,
                card_method: false,
                alert_danger: false,
                alert_warning: false,
                
            },
            //-----------------------
			cashier: {
				discounts: [],
			},
            reapply_whole: false, // will be triggered if a dicount has already been applied.
            cashierTotal: Number('00.00'),
            cash_received:  Number(0.00).toFixed(2),
            //-----------------------
            route: '/api/invoices',
            form: new FormData(),
            client: {
                after_note: true,
                    products_tab: true,
                    discounts_tab: true,
                    treatments_tab: true,
                invoice_cashier: true,
            },
            status: '',
        }
    },

    methods: {
    //cashier ui.
        togglePayMethod: function(pay_method) {
            $(".modal").animate({ scrollTop: $(document).height() }, "slow");
            if(pay_method == 'cash_method'){
                this.show[pay_method] = !this.show[pay_method];
                this.show.card_method = false;
                this.show.submit_pay = true;
                
            }else{
                this.show[pay_method] = !this.show[pay_method];
                this.show.cash_method = false;
                this.show.submit_pay = true;
            }

        },
    //cahshier calculations
		cashierPlus: function(value) {
			let total = this.cashierTotal;
			this.cashierTotal = Number(total) + Number(value);

		},
		cashierMinus: function(value) {
			let total = this.cashierTotal;
			this.cashierTotal = Number(total) - Number(value);
			return this.cashierTotal;

		},
		applyDiscount: function(index) {
			let vi = this;
            let discount = this.cashier.discounts[index];
            if(discount.discount_type == 'monetary') {  
                if(vi.reapply_whole){//if prior discount has been applied already, re apply to whole price
					vi.resetDiscountedTotal(); //re-stablished price to whole-price before prior discount.
					vi.applyMonetaryDiscount(index); // re-apply discount, now with the correct whole price.
				}else{
					vi.applyMonetaryDiscount(index); //apply discount.
				}
            }else{ // percentage
                if(vi.reapply_whole){ //if prior discount has been applied already, re apply to whole price
					vi.resetDiscountedTotal(); //re-stablished price to whole-price before prior discount.
					vi.applyPercentageDiscount(index); // re-apply discount, now with the correct whole price.
				}else{
					vi.applyPercentageDiscount(index); //apply discount.
				}
            }
		},
		onRemoveDiscount: function(pointer) {
			this.cashierPlus(this.cashier.discounts[pointer].discount_amount); //add discount amount that was subtracted.
			this.broadCastOnDiscountRemove(this.cashier.discounts[pointer].id); //remove discount from DiscountCart.vue.
            this.cashier.discounts.splice(pointer, 1); // remove discount form Modal.vue.
            this.reapply_whole = false;
             
        },
        onRemoveLastDiscount: function(pointer) {
			this.broadCastOnDiscountRemove(this.cashier.discounts[pointer].id); //remove discount from DiscountCart.vue.
            this.cashier.discounts.splice(pointer, 1); // remove discount form Modal.vue.
            this.reapply_whole = false;
            this.cashierTotal = 0;
             
		},
		resetDiscountedTotal: function() {
            let vi = this;
            let total = this.cashierTotal; //save current total.
            if(vi.cashier.discounts.length == 1) {
                let discounted_price = this.cashier.discounts[0].discount_amount;//discounted price amount.
                this.cashierTotal = Number(total) + Number(discounted_price); //remove discounted price amount from total.
                Number(this.cashierTotal) + this.cashier.discounts[0].original_total; // add un-discounted price (add sercie-whole-price).
            }
		},
		applyMonetaryDiscount: function(pointer) {
			let vi = this;
			let discount = this.cashier.discounts[pointer];

			if(discount.discount_value <= vi.cashierTotal) {
				vi.$set(discount, 'original_total', vi.cashierTotal);
				vi.$set(discount, 'discount_amount', discount.discount_value);
				let discount_price = vi.cashierMinus(discount.discount_value);
				vi.$set(discount, 'discount_price', discount_price);
                vi.broadCastOnDiscountListActive();
                discount.applied = true; // make discount unavailble on DiscountCart.vue.
				vi.reapply_whole = true;
			}else{
                vi.reapply_whole = false;
                discount.applied = false; //make discount unavailble on DiscountCart.vue.
                vi.show.alert_warning = true;
                vi.delayAlertOff('alert_warning');
				vi.cashier.discounts.splice(pointer, 1);
			}
		},
		applyPercentageDiscount: function(pointer) {
			let vi = this;
			let discount = this.cashier.discounts[pointer];
			let discount_amount = (discount.discount_value / 100) * vi.cashierTotal;

			if( discount_amount <= vi.cashierTotal) {
				vi.$set(discount, 'original_total', vi.cashierTotal);
				vi.$set(discount, 'discount_amount', discount_amount);
				let discount_price = vi.cashierMinus(discount_amount);
				vi.$set(discount, 'discount_price', discount_price);
                vi.broadCastOnDiscountListActive();
                discount.applied = true; // make discount unavailble on DiscountCart.vue.
				vi.reapply_whole = true;
			}else{
                vi.delayAlertOff('alert_warning');
                discount.applied = false; //make discount unavailble on DiscountCart.vue.
				vi.show.alert_warning = true;
				vi.cashier.discounts.splice(pointer, 1);
			}
        },
    //cashier events.
		listenOnDiscount: function() {
			let vi = this;
			Event.listen('onDiscount', function(discountCart) {
				if(discountCart.service == "total price") {
					if(vi.cashier.discounts.length == 0) {
						let index = vi.cashier.discounts.push(discountCart.discount) - 1;
						vi.applyDiscount(index);
					}else{
						vi.show.alert_danger = true;
						vi.delayAlertOff('alert_danger');
					}
				}
			});
		},
		listenOnCloseAlerts: function() {
			let vi = this;
			Event.listen('onCloseAlertWarning', function() {
				vi.show.alert_warning = false;
			});
			Event.listen('onCloseAlertDanger', function() {
				vi.show.alert_danger = false;
			});
		},
		listenOnCashierPlus: function() { // ./ProductCart.vue ./Treatment.Cart.vue
			let vi = this; 
			Event.listen('onCashierPlus', function(value) {
				vi.cashierPlus(value);
				if(vi.cashier.discounts.length == 1) {
					vi.applyDiscount(0);
				}
			});
		},
		listenOnCashierMinus: function() { // ./ProductCart.vue ./Treatment.Cart.vue
			let vi = this; 
			Event.listen('onCashierMinus', function(value) {
                vi.cashierMinus(value);
				if(vi.cashier.discounts.length == 1) {
                    if(vi.cashier.discounts[0].original_total != value){ //means what is being subtracted will not equal to 0.00.
                        vi.applyDiscount(0);
                    }else{ //means what is being subtracted will equal to 0.00 therefore remove any discounts applied to the total.
                        vi.onRemoveLastDiscount(0);
                    }
					
				}
			});
		},
		broadCastOnDiscountRemove: function(discount_ref) {
            Event.fire('onDiscountRemove', discount_ref);

        },
		broadCastOnDiscountListActive: function() {
            let vi = this;
            Event.fire('onDiscountListActive');

		},
		delayAlertOff: _.debounce(function(show_type) {
			this.show[show_type] = false;

		}, 5000),
    //cashier forms.
        storeInvoice: function(client, consultation) {
            let vi = this;
            vi.form.append('client_id', client);
            vi.form.append('consultation_id', consultation);
            vi.form.append('total_price', vi.cashierTotal);

            axios.post(vi.route, vi.form)
                .then( function(response){
                    vi.cashierTotal = 0;
                    vi.broadCastOnInvoice(response.data);
                    setTimeout(function() {
                        Event.fire('onNewConsultation');
                        Event.fire('onConsultEventCreate');
                        vi.resetComponent();
                        vi.show.services = true;
                        vi.show.form_failed = false;
                        vi.show.form_success = false;
                    }, 4000);
                })
                .catch( function(error) {
                    console.log('InvoiceCashier.storeInvoice() Error' + error);
                    vi.show.on_submit = false;
                    if(error){
                        vi.show.services = false;
                        vi.show.pay_method= false;
                        vi.show.form_success = false;
                    }
                });
        },
    //cashier from events.
        listenOnProductForm: function() {
            let vi = this;
            Event.listen('onProductError', function(error) {
                if(!error){
                    vi.show.services = false;
                    vi.show.pay_method= false;
                    vi.show.form_success = true;
                }else{
                    vi.show.services = false;
                    vi.show.pay_method= false;
                    vi.show.form_failed = true;
                    vi.client.product_tab = false;
                }
            });
        },
        listenOnDiscountForm: function() {
            let vi = this;
            Event.listen('onDiscountError', function(error) {
                if(!error){
                    vi.show.services = false,
                    vi.show.pay_method= false,
                    vi.show.form_success = true;
                }else{
                    vi.show.services = false,
                    vi.show.pay_method= false,
                    vi.show.form_failed = true;
                    vi.client.discount_tab = false;
                } 
            });
        },
        listenOnTreatmentForm: function() {
            let vi = this;
            Event.listen('onTreatmentError', function(error) {
                if(!error){
                    vi.show.services = false,
                    vi.show.pay_method= false,
                    vi.show.form_success = true;
                }else{
                    vi.show.services = false,
                    vi.show.pay_method= false,
                    vi.show.form_failed = true;
                    vi.client.treatment_tab = false;
                } 
            });
        },
        broadCastOnInvoice: function(invoice) {
            let client = this.reference;
            Event.fire('onInvoice', {invoice, client} );
        },
        listenOnAfterNoteError: function() {
            let vi = this;
            Event.listen('onAfterNoteError', function() {
                setTimeout( function(){
                    vi.show.on_submit = false;
                },6000);
            });
        },
        listenOnAfterNote: function() {
            let vi = this;
            Event.listen('onAfterNote', function(after_notes_id) {
                vi.storeInvoice(vi.reference, after_notes_id);
            });

        },
        broadCastOnSubmit: function() {
            this.show.on_submit = true;
            Event.fire('onStoreAfterNote');
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
    //cashier calculations.
		this.listenOnDiscount();
		this.listenOnCashierPlus();
		this.listenOnCloseAlerts(); 
        this.listenOnCashierMinus();

    //cashier submit.
        this.listenOnAfterNote();
        this.listenOnProductForm();
        this.listenOnDiscountForm();
        this.listenOnTreatmentForm();
        this.listenOnAfterNoteError();
    
    //component.
        this.listenOnResetComponent();
		
	}
}
</script>


// CLIENT STYILING
<style scoped>
	.input-group-btn:not(:first-child):not(:last-child) > .btn {
		border-radius: 0;
	}
	.no-border {
		border: none !important;
	}
	.pay-border {
		border: 1px outset silver !important;
	}
</style>