<template>
    <div>
        <hr class="mb-1 mt-2"/>	
        <table class="table table-hover table-striped table-sm bg-white my-0">
            <tbody>
                <tr v-if="discounts" v-for="(discount, index)  in discounts" :key="index + Math.floor(Math.random() * Math.floor(1000))">
                    <td class="text-center width-30">
                        <a v-if="!discount.applied" @click="onRemoveDiscount(index)" href="#" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-trash-o fa-lg"></i>
                        </a>
                    </td>
                    <td class="width-15">
                        <i class="fa fa-cart-plus fa-lg text-success"></i> 
                    </td>
                    <td> {{ discount.name  }} </td>
                    <td> 
                        {{discount.discount_type == 'percentage'? '' : '$'}}{{discount.discount_value}}{{discount.discount_type == 'percentage'? '%' : '' }}OFF
                    </td>
                    <td class="text-center width-75 bg-light-secondary">
                        <a :class="{disabled : discount.applied }" class="cursor-pointer text-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span v-if="discount.applied"><del class="gfe-text-red">Applied</del></span>
                                <span v-else>Apply</span>
                        </a>
                        <div class="dropdown-menu gfe-sm-dropmenu">
                            <a @click="broadCastOnDiscount('treatment', discount)" class="dropdown-item" href="#">
                                Treatments
                            </a>
                            <a @click="broadCastOnDiscount('product', discount)" class="dropdown-item" href="#">
                                Products
                            </a>
                            <a @click="broadCastOnDiscount('total price', discount)" class="dropdown-item" href="#">
                                Total Pice
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script type="text/javascript">

//dependencies.
import ucfirst from '../../../helpers/ucfirst.js';

export default {

    data: function() {
        return {
            discounts: [],
            view: {
                alert_waring: false,
            },
            route: '/api/purchase-discounts',
            client_ref: '',
            invoice_ref: '',
            form: [],
        }
    },

    methods: {
    //events.
        onRemoveDiscount: function(index) {
            let vi = this;    
            vi.broadCastOnRemoveCurrentDiscount(index);                
            vi.discounts.splice(index, 1);
            vi.broadCastOnDiscountListActive(); // enable discount dropdown list.

        },
        listenOnAddDiscount: function() {
			let vi = this;
			Event.listen('onAddDiscount', function(discount) {
                vi.$set(discount, 'applied', false); // create internal applied property
                vi.discounts.push(discount);
            });

        },
        listenOnDiscountRemove: function() {
            let vi = this;
            Event.listen('onDiscountRemove', function(discount_ref) {
                let i;
                let first_match_stop;
                let discounts = vi.discounts;
                let discountId = discount_ref;
                let discountsSize = vi.discounts.length;
                
                for(i = 0; i <= discountsSize; i++) {
                    let prop;
                    for(prop in discounts[i]) {

                        if( prop == 'id' && 
                            discounts[i].id == discountId 
                            && discounts[i].applied == true
                        ){
                            first_match_stop = true;
                            discounts[i].applied = false;
                            discounts.splice(i, 1);
                            break;
                        }
                    }
                    if(first_match_stop){ break; }
                }
            });

        },
        listenOnDiscountApplied: function() {
            let vi = this;
            Event.listen('onDiscountApplied', function(service) {
                let i;
                let after_match_stop;
                let discounts = vi.discounts;
                let discountsSize = vi.discounts.length;
                let discountId = service.service_discount_id;

                for(i = 0; i <= discountsSize; i++) {
                    let prop;
                    for(prop in discounts[i]) {
                        if( prop == 'id' && 
                            discounts[i].id == discountId 
                            && discounts[i].applied == false
                        ){
                           
                            after_match_stop = true;
                            discounts[i].applied = true;
                            vi.$set(discounts[i], 'service', service.service);
                            vi.$set(discounts[i], 'service_id', service.service_id);
                            vi.$set(discounts[i], 'service_original_price', service.service_original_price,)
                            break;
                        }
                    }
                    if(after_match_stop){ break }
                }
            });
        
        },
        broadCastOnDiscount: function(service, discount) {
            
            Event.fire('onDiscount', {service, discount} );

        },
        broadCastOnDiscountListActive: function() {
            let vi = this;
            Event.fire('onDiscountListActive');

        },
        broadCastOnRemoveCurrentDiscount: function(index) {
            let current_discount_ref = this.discounts[index].id;
            Event.fire('onRemoveCurrentDiscount', current_discount_ref)

        },
    //form events.
        storePurchaseDiscount: function(pointer) {
           let vi = this;
            axios.post(vi.route, vi.form[pointer])
                .then( function(response) {
                    Event.fire('onDiscountError', false);
                })
                .catch( function(error) {
                    Event.fire('onDiscountError', true);
                    console.log('DiscountCart.storePurchaseDiscount() Error' + error);
                });

            if(pointer == (vi.discounts.length - 1) ){
                vi.resetComponent();
            }  
        },
        appendPurchaseDiscount: function() {
            let vi = this;
            let discounts  = vi.discounts;
            let size = vi.discounts.length;
                if(size > 0){
                    let i;
                    let obj;
                    for(i = 0; i < size; i++) {
                        let prop;
                        obj = null;
                        obj = new FormData();

                        for(prop in discounts[i]) {
                            if(prop == 'id') {
                                obj.append('client_id', vi.client_ref);
                                obj.append('invoice_id', vi.invoice_ref);
                                obj.append('discount_id', [discounts[i][prop]]);

                            }else if(prop == 'service' ||  prop == 'service_original_price' ||
                                     prop == 'service_id' || prop == 'discount_type' || prop == 'discount_value'
                                    ){
                                    obj.append(prop, [discounts[i][prop]]);
                            }
                        }
                        vi.form.push(obj);
                        vi.storePurchaseDiscount(i);
                    }
                }

        },
        listenOnInvoice: function() {
            let vi = this;
            Event.listen('onInvoice', function(ref){
                vi.client_ref = ref.client;
                vi.invoice_ref = ref.invoice;
                vi.appendPurchaseDiscount();
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
        this.listenOnInvoice();
        this.listenOnAddDiscount();
        this.listenOnResetComponent();
        this.listenOnDiscountRemove();
        this.listenOnDiscountApplied();
    
    }
}
</script>


