<template>
    <div>
    <!-- dropdown-->
        <div class="dropdown">
        <!-- button -->
            <button type="button" 
                    aria-haspopup="true" 
                    aria-expanded="false"
                    data-toggle="dropdown" 
                    id="dropdownMenuButton"
                    class="btn btn-primary btn-block dropdown-toggle btn-sm"

                    @click="indexDataOnce()"
            >
            Products
            </button>
        <!-- dropdown-menu -->
            <div class="dropdown-menu pt-0 gfe-full-width">
            
                <alert-loading :state="alert.loading"></alert-loading>
                <alert-error :state="alert.error"></alert-error>

                <div v-show="alert.show" class="overflow-200">
                    <table class="table table-hover table-sm">
                        <tbody>
                            <tr v-if="!product.discontinue" :class="[product.quantity == 0 ? 'disabled': '']" v-for="(product,index)  in products" :key="product.id + '-list'"  @click="broadCastOnAddProduct(index, product)">
                                <td class="text-left">{{ product.name }}</td>
                                <td class="align-middle w-120"> 
                                    ${{product.price }}
                                </td>
                                <td class="align-middle"> 
                                    <span v-if="product.quantity > 0">Qty: {{ product.quantity }}</span>
                                    <span v-else class="text-danger"> out of stock! </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- ../dropdown-menu -->
        </div>
    <!-- ../dropdown-->
    </div>
</template>


// COMPONENT
<script type="text/javascript">

//dependencies.
import AlertLoading from '../../alert/Loading.vue';
import AlertError from '../../alert/Error.vue';

export default {

	components: {
        'alert-loading': AlertLoading,
        'alert-error': AlertError
    },
    
    data: function() {
		return {
            route: '/api/products',
            products: '',
            alert: {
                loading: false,
                error: false,
                show: true
            },
		}
	}, 

    methods: {
    //data rendering.
        indexDataOnce: function() {
            let vi = this;
            if(vi.products.length == 0) {
                vi.indexData();
            }
            
        },
    //http request.
        indexData: function() {
            let vi = this;
            vi.alert.show = false;//hide products table.
            vi.alert.loading = true;// show loading icon
            axios.get(vi.route)
                .then( function(response) {
                    vi.alert.show = true; //un-hide products table.
                    vi.alert.loading = false; //hide loading icon.
                    vi.products = response.data;
                })
                .catch( function(error) {
                    console.log('ProductList.indexData() Error' + error);
                    vi.alert.show = false;//hide products table.
                    vi.alert.error = true;;//show alert error.
                    alert();
                });

        },
    //events.
        broadCastOnAddProduct: function (index, product) {
            let vi = this;

            const currentQty = vi.products[index].quantity;
            vi.products[index].quantity = currentQty - 1;

            let _elClone = {
                id: product.id,
                name: product.name,
                price: product.price,
            }
            Event.fire('onAddProduct', _elClone);

        }	
	},

    created: function() {
        //
    }
    
}
</script>

<style scoped>
    .w-120 {
        width: 120px !important;
    }
</style>