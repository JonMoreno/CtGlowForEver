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
                Treatments
                </button>
            <!-- dropdown-menu -->
                <div class="dropdown-menu gfe-full-width pt-0">
                   
                    <alert-loading :state="alert.loading"></alert-loading>
                    <alert-error :state="alert.error"></alert-error>

                    <div v-show="alert.show" class="overflow-200">
                        <table class="table table-hover table-sm">
                            <tbody>
                                <tr v-for="treatment  in treatments" :key="treatment.id + '-list'" @click="broadCastOnAddTreatment(treatment)" >
                                    <td class="text-left">{{ treatment.name }}</td>
                                    <td class="align-middle w-120"> 
                                        ${{ treatment.price }}
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
            route: '/api/treatments',
            treatments: '',
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
            if(vi.treatments.length == 0) {
                vi.indexData();
            }

        },
    //http request.
        indexData: function() {
            let vi = this;
            vi.alert.show = false;//hide treatments table.
            vi.alert.loading = true;// show loading icon
            axios.get(vi.route)
                .then( function(response) {
                    vi.alert.show = true; //un-hide treatments table.
                    vi.alert.loading = false; //hide loading icon.
                    vi.treatments = response.data;

                })
                .catch( function(error) {
                    console.log('TreatmentList.indexData() Error' + error);
                    vi.alert.show = false;//hide treatments table.
                    vi.alert.error = true;;//show alert error.
                    alert();
                });

        },
    //events.
        broadCastOnAddTreatment: function (treatment) {
            let vi = this;
            let _elClone = {
                id: treatment.id,
                name: treatment.name,
                price: treatment.price,
            }
            Event.fire('onAddTreatment', _elClone);

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