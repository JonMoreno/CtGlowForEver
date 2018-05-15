
// COMPONENT TEMPLATE
<template>
    <div>
    <!-- Search input bar -->
        <div class="input-group">
            <i class="fa fa-search gfe-search-align text-primary"></i>
            <input 
                type="search" 
                @keyup="onSearch()"
                name="search_client"
                v-model.trim="search.query"
                placeholder="Search client by first or last name..."
                class="form-control form-control-sm gfe-search-pl fix-width"
            >  
        </div>
    <!-- Search result list -->
        <div v-if="search.query.length > 0" class="list-group pos-absolute overflow shadow">
        <!-- result helpul info -->
            <a class="list-group-item list-group-item-action bg-light-secondary text-capitalize text-left py-1 pl-3 disabled">
                <span v-if="search.query.length > 0 && results.length == 0"> 
                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> 
                    no matching records 
                </span>
                <span v-else>
                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> 
                    results... 
                </span>
            </a>
        <!-- results list -->
            <a :key="result.id"
                @click="onSelect(index)"
                v-for="(result, index) in results" 
                :class="[result.selected ? 'active rounded text-white': 'text-primary']"
                class="list-group-item list-group-item-action text-capitalize text-left py-0"
            >
                <i class="fa fa-user-o"></i> {{ result.first_name + ' ' + result.last_name }} 
                <span 
                    :class="[result.selected ? 'text-white': 'text-muted']"
                    class="d-block pl-4"> 
                    Phone:{{ result.cellular }}
                </span>
            </a>
        </div><!-- ../Search result list -->
    </div>
</template>

// COMPONENT
<script type="text/javascript">
//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
window._ = require('lodash');
import NewClient from './NewClient.vue';


export default {
/*------------------------------------------------------
| COMPONENT: Product List
|-------------------------------------------------------
| This component handles  searching for a client 
| and returns the selected result to the 
| parent component.
|
*/

//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function(){
        return {
            results: '',
            selected: '',
            search: {
                route: '/api/clients/search',
                query: '',
            },
        }
    },
//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
    methods:{
    //--------------------------------------------------
	// DATA MANIPULATION
	//--------------------------------------------------  
        addSelectProp: function(items) {
            for(let prop in items){
                items[prop].selected = false;
            }
            return items;
        },
    //--------------------------------------------------
	// EVENTS
	//--------------------------------------------------
        onSearch: _.debounce(function(){
            if(this.search.query.length > 0){
                this.queryResults();
            }
        }, 600),
        onSelect: function(index){
            let vi = this;
            vi.results[index].selected = true;
            setTimeout( function() {
                vi.selected = vi.results[index];
                vi.results = '';
                vi.search.query = '';
                vi.broadCastOnFindClient();
            },300);

        },
    //--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
        queryResults: function(){
            let vi = this;
            axios.get(vi.search.route + '/' + vi.search.query)
                .then( function(response){
                    vi.results = null;
                    vi.results = vi.addSelectProp(response.data);
                })
                .catch( function(error){
                    console.log('SearchClient.queryResults()  Error:' + error.response);
                });

        },
    //--------------------------------------------------
	// COMPONENT BROADCASTING
	//--------------------------------------------------
        broadCastOnFindClient(){
            let vi = this;
            Event.fire('onFindClient', vi.selected);
        },
    }
}
</script>

// COMPONENT STYLING
<style scoped>
    .gfe-search-align {
        position: absolute;
        z-index: 1000;
        left: 15px;
        top: 8px;
    }
    .gfe-search-pl {
        padding-left: 35px;
    }
    .overflow {
        overflow: scroll !important;
        max-height: 225px !important;
    }
    .fix-width{
        width: 325px;
    }
    .pos-absolute{
        position: absolute;
        width: 316px;
        z-index: 1000;
    }
    .shadow {
        box-shadow: 0px 3px #555;
    }
</style>

