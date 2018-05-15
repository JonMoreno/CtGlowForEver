// COMPONENT TEMPLATE
<template>
    <div 
        @click.stop.prevent="clearList()"
        class="row">
        <div 
            @mouseout.stop.prevent="preClearList()" 
            class="col-11 col-sm col-md-11 col-lg-10 col-xl-8 mx-auto ">
        <!-- Search Product -->
            <form class="input-group mb-1 mt-3">
                <div class="input-group mx-5">
                    <i class="fa fa-search gfe-search-align"></i>
                    <input 
                        @keyup="onSearch()"
                        v-model.trim="search.query" 
                        
                        name="search_product"
                        type="search" 
                        aria-label="Search"
                        class="form-control pl-5 circle"
                        placeholder="Search Product"
                    >  
                </div>         
            </form>
        <!-- Product List -->
            <div class="list-group">
            <!-- New Item Form-->
                <new-item-form></new-item-form>
            <!-- List -->
                <transition-group name="list">
                    <list-item 
                        v-for="(item, index) in items" 
                        :item="item" 
                        :index="index"
                        :key ="item.id"
                    ></list-item>
                </transition-group>  
            <!-- Empty list -->
                <transition name="bounce">
                    <div v-if="items.length == 0" class="list-group-item text-center px-2 mt-5">
                        <div class="lead">
                            <i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>
                            No matching records.
                        </div>
                    </div>
                </transition>
            </div><!-- ../Product List -->
        </div>
    </div>
</template>

// COMPONENT
<script type="text-javascript">

//------------------------------------------------------
// DEPENDENCIES
//------------------------------------------------------
window._ = require('lodash');
import NewItem from './NewItem.vue';
import ListItem from './ListItem.vue';

export default {
/*------------------------------------------------------
| COMPONENT: Product List
|-------------------------------------------------------
| This component will handle product:
|   - searching 
|   - creating
|   - editing
|   - deleting
*/

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components: {
        'list-item': ListItem,
        'new-item-form': NewItem,
    },
//------------------------------------------------------
// COMPONENT PROPS
//------------------------------------------------------
    props: {
        records: {
            type: Array,
            required: true
        }
    },
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function() {
        return {
            cache: [],
            items: [],
            search: {
                query: '',
                route: '/api/products/search/'
            },
            pre_clear: false, 
        }
    },
//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
    methods: {
    //--------------------------------------------------
	// CLEAR OUT SELECT LIST ITEM
	//--------------------------------------------------
        clearList: function() {
            if(this.pre_clear){
                this.resetList();
            }
        },
        preClearList: function(){
            this.pre_clear = true;
        },
    //--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
        query: function() {
            let vi = this;
            if(vi.search.query.length > 0){
                axios.get(vi.search.route + vi.search.query)
                    .then( function(response){
                        vi.items = vi.addSelectProp(response.data);
                    })
                    .catch( function(error){
                        console.log('ProductList.searchQuery() Error:'+error.response);
                    });
            }
        },
    //--------------------------------------------------
	// FORM HANDLING
	//--------------------------------------------------
        onSearch: _.debounce(function() {
            if(this.search.query.length > 0){
                this.query()
            }else if(this.cache.length > 0){
                this.items = this.cache;
            }
        }, 800),

    //--------------------------------------------------
	// DATA MANIPULATION
	//--------------------------------------------------
        resetList: function() {
            let vi = this;
            vi.pre_clear = false;
            for(let i = 0; i < vi.items.length; i++){
                vi.items[i].selected = false;
            }
        },
        addSelectProp: function(items) {
            for(let prop in items){
                items[prop].status = true;
                items[prop].selected = false;
            }
            return items;
        },
        toggleSelection: function(index) {
            let vi = this;
            let incomplete;
            vi.pre_clear = false;
            let size = vi.items.length;
            for(let i = 0; i < size; i++){
                if(i == index){
                    !vi.items[i].status? incomplete = i : '';
                    vi.items[i].selected = true;

                }else if(i !== (size - 1)){
                    !vi.items[i].status? incomplete = i : '';
                    vi.items[i].selected = false;
                    
                }else if(incomplete != undefined){
                    vi.items[index].selected = false;
                    vi.items[incomplete].selected = true;
                }
            }
        },
    //--------------------------------------------------
	// COMPONENT BROADCASTING EVENTS
	//--------------------------------------------------
        botOnAsideNav: function() {
            let services = {
                services: {
                    toggle_submenu: true,
                },
                submenu: {
                    services: true,
                    products: true,
                }
            }
             Event.fire('onAsideNav', services )
        }
    },
//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
    created: function() {
        let vi = this;
        Event.listen('onAddItem', function(item) {
            //add some component needed props to new list item.
            item.status = true;
            item.selected = false;
            //prepend new list item.
            vi.items.unshift(item);
        });
        Event.listen('onSelectProduct' , function(index) { //ListItem.select()
            vi.toggleSelection(index);
        });
        Event.listen('onRemoveListItem', function(index){ //ListItem.destory()
            vi.items.splice(index, 1);
        })
    },

    mounted: function() {
        this.items = this.addSelectProp(this.records);
        this.cache = this.items;
        this.botOnAsideNav();

       
    }
}
</script>

//COMPONENT STYLING
<style scoped>
    .gfe-search-align {
        position: absolute;
        z-index: 1000;
        left: 15px;
        top: 10px;
    }
    .overflow {
        overflow: scroll !important;
        height: 450px !important;
    }
    .circle {
        border-top-left-radius: 25px !important;
        border-bottom-left-radius: 25px !important;
        border-top-right-radius: 25px !important;
        border-bottom-right-radius: 25px !important;
    }
</style>




