//TEMPLATE
<template>
    <div>
        <transition name="fade">
            <div v-if="display" class="py-2 px-2">
                <transition name="bounce">
                    <alert-icon-fail :state="show.alertIconFail"></alert-icon-fail>
                </transition>
                <transition name="fade">
                    <div class="row no-gutters" v-if="show.mainContent">
                        <div class="col-12 col-lg-6 pr-3">
                            <listgroup-treatment :info="treatments" :discounts="discounts"></listgroup-treatment>
                        </div>
                        <div class="col-12 col-lg-6 pr-3">
                            <listgroup-product :info="products" :discounts="discounts"></listgroup-product>
                        </div>
                        <div class="col-12 mx-auto pr-4">
                            <invoice-total :info="invoice" :discounts="discounts"></invoice-total>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </div>
</template>

//COMPONENT
<script type="text/javascript">

//dependencies.
import AlertIconFail from '../../alert/icon/fail.vue';

import InvoiceTotal from './InvoiceTotal.vue';
import ListGroupProduct from './ListGroupProduct.vue';
import ListGroupTreatment from './ListGroupTreatment.vue';


export default {
    
    components: {
        'alert-icon-fail': AlertIconFail,
        'invoice-total': InvoiceTotal,
        'listgroup-product': ListGroupProduct,
        'listgroup-treatment': ListGroupTreatment
    },

    props: {
        reference: {
            type: Number,
            required: true
        },
        display: {
            type: Boolean,
            required: true
        }
    },

    data: function() {
        return {
            invoice: '',
            products: [],
            discounts: [],
            treatments: [],
            registered: false,
            show: {
                mainContent: true,
                alertIconFail: false,
            }
        }
    },

    watch: {
        display: function(newVal , oldVal) {
            this.showServices();
        }
    },

    methods: {
        showServices: function() {
            let vi = this;
            if(vi.display && !vi.registered){
                console.log('watch ON');
                !vi.invoice ? vi.loadInvoice(): '';
            }
        },
        loadInvoice: function() {
            let vi = this;
            axios.get('/api/invoices/' + vi.reference)
                .then( function(response) {
                    vi.invoice = response.data;
                    vi.products.length == 0 ? vi.loadProducts(): '';
                    vi.discounts.length == 0 ? vi.loadDiscounts(): '';
                    vi.treatments.length == 0 ? vi.loadTreatments(): '';
                    vi.registered = true;
                })
                .catch( function(error) {
                    console.log('ServieTab.loadInvoice() Error:' + error)
                    vi.show.mainContent = false;
                    vi.show.alertIconFail = true;
                })
        },
        loadProducts: function() {
            let vi = this;
            axios.get('/api/purchase-products/' + vi.invoice[0].id)
                .then( function(response) {
                    for(let i = 0; i < response.data.length; i++){
                        vi.products.push(response.data[i]);
                    }
                })
                .catch( function(error) {
                    console.log('ServieTab.loadProducts() Error:' + error)
                    vi.show.mainContent = false;
                    vi.show.alertIconFail = true;
                })
        },
        loadDiscounts: function() {
            let vi = this;
            axios.get('/api/purchase-discounts/' + vi.invoice[0].id)
                .then( function(response) {
                    for(let i = 0; i < response.data.length; i++){
                        vi.discounts.push(response.data[i]);
                    }
                })
                .catch( function(error) {
                    console.log('ServieTab.loadDiscounts() Error:' + error)
                    vi.show.mainContent = false;
                    vi.show.alertIconFail = true;
                })
        },
        loadTreatments: function() {
            let vi = this;
            axios.get('/api/purchase-treatments/' + vi.invoice[0].id)
                .then( function(response) {
                    for(let i = 0; i < response.data.length; i++){
                        vi.treatments.push(response.data[i]);
                    }
                })
                .catch( function(error) {
                    console.log('ServieTab.loadTreatments() Error:' + error)
                    vi.show.mainContent = false;
                    vi.show.alertIconFail = true;
                })
        },

    }



}
</script>


<style scoped>
    .badge {
        font-size: 90% !important;
    }

</style>


