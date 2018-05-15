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
                    :class="{disabled : apply_first }">

            Discounts
            </button>
        <!-- dropdown-menu -->
            <div class="dropdown-menu gfe-full-width pt-0">
                
                <alert-loading :state="alert.loading"></alert-loading>
                <alert-error :state="alert.error"></alert-error>

                <div v-show="alert.show" class="overflow-150">
                    <table class="table table-hover table-sm">
                        <tbody>
                            <tr v-for="discount  in discounts" :key="discount.id + '-list'" @click="broadCastOnAddDiscount(discount)">
                                <td class="text-left">{{ discount.name }}</td>
                                <td class="align-middle w-120"> 
                                    {{discount.discount_type == 'percentage'? '' : '$'}}{{discount.discount_value}}{{discount.discount_type == 'percentage'? '%' : '' }} OFF
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
            route: '/api/discounts',
            alert: {
                loading: false,
                error: false,
                show: true
            },
            apply_first: false,
			discounts: ''
		}
	}, 

    methods: {

    //data rendering.
        indexDataOnce: function() {
            let vi = this;
            if(vi.discounts.length == 0) {
                vi.indexData();
            }

        },
    //http request.
        indexData: function() {
            let vi = this;
            vi.alert.show = false;//hide discounts table.
            vi.alert.loading = true;// show loading icon
            axios.get(vi.route)
                .then( function(response) {
                    vi.alert.show = true; //un-hide discounts table.
                    vi.alert.loading = false; //hide loading icon.
                    vi.discounts = response.data;

                })
                .catch( function(error) {
                    console.log('DiscountCart.indexData() Error' + error);
                    vi.alert.show = false;//hide discounts table.
                    vi.alert.error = true;;//show alert error.
                    alert();

                });

        },
    //events.
        listenOnDiscountListActive: function() {
            let vi = this;
            Event.listen('onDiscountListActive', function() {
                vi.apply_first = false;
            });

        },
        listenOnDiscountApplied: function() {
            let vi = this;
            Event.listen('onDiscountApplied', function(discount_ref) {
                // discount_ref used by DiscountCart 
                vi.apply_first = false;
            });

        },
        broadCastOnAddDiscount: function (discount) {
            let vi = this;
            vi.apply_first = true; // disable till discount is applied.
            let _elClone = {
                id: discount.id,
                name: discount.name,
                discount_type: discount.discount_type,
                discount_value: discount.discount_value
            }
            Event.fire('onAddDiscount', _elClone);

        }	
	},

    created: function() {
        this.listenOnDiscountApplied();
        this.listenOnDiscountListActive();
        
    }
}
</script>


<style scoped>
    .w-120 {
        width: 120px !important;
    }
</style>

