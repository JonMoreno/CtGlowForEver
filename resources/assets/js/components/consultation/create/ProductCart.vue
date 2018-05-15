<template>
    <div>
        <hr class="mb-1 mt-2"/>
        <!-- alert-warning-discount-exceeds -->
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
                The discount you are trying to apply exceeds the product's price.
                </span>
            </alert-warning>
        </transition><!-- ../alert-warning-discount-exceeds -->

        <!-- current-discount-checkboxes -->
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
        </transition><!-- ../current-discount-checkboxes -->

        <!-- product-cart-list -->
        <table class="table table-hover table-striped table-sm  mb-0 bg-white">
            <tbody>
                <tr v-if="tab.products" v-for="(product, index) in tab.products" :key="index + Math.floor(Math.random() * Math.floor(1000))">
                    <td class="text-center width-30">
                        <a  @click="onDeleteProduct(index)" href="#" class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-trash-o fa-lg"></i>
                        </a>
                    </td>
                    <td class="width-15">
                        <i class="fa fa-cart-plus fa-lg text-success"></i> 
                    </td>
                    <td>
                        {{ product.name }}
                    </td>
                    <td class="text-right">
                        <span v-if="product.discount_type" class="gfe-text-red">
                            -{{product.discount_type == 'monetary'? '$' : ''}}{{product.discount_value}}{{product.discount_type == 'percentage'? '%' : ''}}OFF
                        </span>
                    </td>
                    <td class="text-right"> 
                        <span v-if="product.discount_value">
                            <del class="gfe-text-red">+${{ product.price }} </del>
                        </span>
                        <span v-else>
                            +${{ product.price }}
                        </span>
                    </td>
                    <transition 
                        name="custom-classes-transition"
                        enter-active-class="animated bounceInRight"
                        leave-active-class="animated bounceOutRight"
                    >
                        <td v-if="!product.discount_applied && view.current_discount" class="text-center width-35 px-0 py-0 bg-light-danger">
                            <input @change="applyDiscount(index , product.discount_applied )" v-model="product.discount_applied" type="checkbox" class="gfe-checkbox">
                        </td>
                    </transition>
                </tr>
            </tbody>
        </table><!-- ../product-cart-list -->

        <!-- total-balance-display -->
        <div v-if="tab.products.length > 0" class="d-flex justify-content-end my-2">
            <!-- discount-view-list -->
            <div class="d-flex flex-column">
                <small class="text-right">- product discounts</small>

                <ul class="list-group list-group-flush pr">
                    <span v-for="(discount, index) in tab.products" :key="index + Math.floor(Math.random() * Math.floor(1000))">
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
            </div><!-- ../discount-view-list -->
        </div> <!-- total-balance-display -->

        <!-- Total Products Price -->
        <div v-if="tab.products.length > 0" class="text-right">
            <div class="d-inline px-2 py-2 bg-white rounded">
                <strong class="text-fancy-dark">Products:</strong>
                <span class="gfe-text-red"> ${{tab.total.toFixed(2)}} </span>
            </div>
        </div>

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
                products: [],
                total: 0.00,
            },
            view: {
                current_discount: false,
                alert_warning: false,
            },
            route: '/api/purchase-products',
            client_ref: '',
            invoice_ref: '',
            form: [],
        }
    },

    methods: {
        addToTotal: function(value) {
            let total = this.tab.total;
            this.tab.total = Number(total) + Number(value);
            this.broadCastCashierPlus(value);
          
        },
        subtractOfTotal: function(value) {
            let total = this.tab.total;
            this.tab.total = Number(total) - Number(value);
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
        onAddProduct: function(product) {
            let index = this.tab.products.push(product) - 1;
            this.addToTotal( this.tab.products[index].price);

        },
        onDeleteProduct: function(index) {
            let vi = this;
            vi.deleteFromCashierTotal(index);
            if(vi.tab.products[index].discount_applied == true){
                vi.broadCastOnDiscountRemove(vi.tab.products[index].discount_id);
            }
            vi.tab.products.splice(index, 1);// remove from cart list.
               
        },
        applyDiscountProps: function(product) {
            let vi = this;
            let discount = vi.current_discount;
            vi.$set(product, 'discount_applied', true);
            vi.$set(product, 'discount_id', discount.id);
            vi.$set(product, 'discount_name', discount.name);
            vi.$set(product, 'discount_type', discount.discount_type);
            vi.$set(product, 'discount_value', discount.discount_value); 

        },
        applyMonetaryDiscount: function(index) {
            let vi = this; 
            let current_discount = vi.current_discount;
            let tab_product = vi.tab.products[index];
            
            if(Number(tab_product.price) >= Number(current_discount.discount_value)) {
                vi.applyDiscountProps(tab_product); //apply discount props to tab product.
                vi.subtractOfTotal(tab_product.price); //subtract original product price.
                let discounted_product = tab_product.price - current_discount.discount_value;//apply discount to product.
                vi.$set(tab_product, 'discount_price', discounted_product); //add discount prop to product.
                vi.addToTotal(discounted_product);//add to total discounted product.
                vi.view.current_discount = false; //hide discount apply checkbox.
                vi.broadCastOnDiscountApplied(tab_product);

            }else {
                vi.$set(tab_product, 'discount_applied', false);
                vi.view.alert_warning = true;
                vi.delayAlertWarningOff();
            }

        },
        applyPercentageDiscount: function(index) {
            let vi = this;
            let discount = vi.current_discount;
            let product = vi.tab.products[index];
            let discount_amount = (discount.discount_value / 100) * product.price;

            if(Number(product.price) >= Number(discount_amount) ){
                vi.applyDiscountProps(product); //apply discount props to tab product.
                vi.subtractOfTotal(product.price); //subtract original product price.
                let discount_price = product.price - discount_amount;//apply discount to product.
                //vi.$set(product, 'discount_amount', discount_amount);
                vi.$set(product, 'discount_price', discount_price); //add discount prop to product.


                vi.addToTotal(discount_price);//add to total discounted product.
                vi.view.current_discount = false; //hide discount apply checkbox.
                vi.broadCastOnDiscountApplied(product);
            }else{
                vi.$set(product, 'discount_applied', false);
                vi.view.alert_warning = true;
                vi.delayAlertWarningOff();
            }

        },
        deleteFromCashierTotal: function(index) {
            let vi = this;
            if(this.tab.products[index].discount_value > 0) {               
                vi.subtractOfTotal(vi.tab.products[index].discount_price);
            }else{ 
                vi.subtractOfTotal(vi.tab.products[index].price);
            }

        },
    //events.
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
        listenOnAddProduct: function() {
			let vi = this;
			Event.listen('onAddProduct', function(product) {
                vi.onAddProduct(product);
            });

        },
        listenOnDiscount: function() {
            let vi = this;
            Event.listen('onDiscount', function(discountCart) {
                if(discountCart.service == 'product'){
                    vi.current_discount = {};
                    vi.view.current_discount = true;
                    vi.current_discount = discountCart.discount; 
                }else{
                    vi.view.current_discount = false;
                }
            });

        },	
        broadCastCashierPlus: function(amount) {
            Event.fire('onCashierPlus', amount);
            
        },
        broadCastCashierMinus: function(amount) {
            Event.fire('onCashierMinus', amount);

        },
        broadCastOnDiscountRemove: function(discount_ref) {
            
            Event.fire('onDiscountRemove', discount_ref);

        },
        broadCastOnDiscountApplied: function(discounted_product) {
            let references = {
                'service': 'product',
                'service_id': discounted_product.id,
                'service_original_price': discounted_product.price,
                'service_discount_id': discounted_product.discount_id
            }
            Event.fire('onDiscountApplied', references);// DiscountCart.vue

        },
        delayAlertWarningOff: _.debounce( function() {
            this.view.alert_warning = false;

        }, 10000),
        //form events.
        storePurchaseProduct: function(pointer) {
            let vi = this;

            axios.post(vi.route, vi.form[pointer])
                .then( function(response) {
                    Event.fire('onProductError', false);
                })
                .catch( function(error) {
                    console.log('ProductCart.storePurchaseProduct() Error' + error);
                    Event.fire('onProductError', true);
                }); 
            if(pointer == (vi.tab.products.length - 1) ){
                vi.resetComponent();
            }  
        },
        appendPurchaseProduct: function() {
            let vi = this;
            let products  = vi.tab.products;
            let size = vi.tab.products.length;
                if(size > 0){
                    let i;
                    let obj;
                    for(i = 0; i < size; i++) {
                        let prop;
                        obj = null;
                        obj = new FormData();
                        for(prop in products[i]) {
                            if(prop == 'id') {
                                obj.append('client_id', vi.client_ref);
                                obj.append('invoice_id', vi.invoice_ref);
                                obj.append('product_id', [products[i][prop]]);
                            }else if(prop == 'price') {
                                obj.append('sold_price', [products[i][prop]]);
                            }
                        }
                        vi.form.push(obj);
                        vi.storePurchaseProduct(i);
                    }
                }

        },
        listenOnInvoice: function() {
            let vi = this;
            Event.listen('onInvoice', function(ref){
                vi.client_ref = ref.client;
                vi.invoice_ref = ref.invoice;
                vi.appendPurchaseProduct();
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
        this.listenOnAddProduct();
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
