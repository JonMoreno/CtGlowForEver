

// CLIENT CARDS TEMPLATE
<template>
    <div>

    <!-- Alert Fail -->
        <alert-fail :state="alert_fail.state" > 
            {{ alert_fail.message }} 
        </alert-fail>

    <!-- Alert Message -->
        <alert-message :state="alert_message.state"> 
            <i class="fa fa-comments fa-3x" aria-hidden="true"></i> 
            {{ alert_message.message }} 
        </alert-message>
    <!-- Client Card List -->
    <transition-group name="list"
	>
            <div v-if="list"  v-for="(client,index) in list" :key="client.id" class="col-12 list-item">
                <client-card :info="client" :index="index" :toggle="selectedCard"></client-card>
                <br/>
                <br/>
            </div>
    </transition-group>
        
    <!-- Alert Loading -->
        <alert-loading :state="alert_loading.state" ></alert-loading>
        

    </div>
</template>  


// CLIENT CARDS COMPONENT
<script type="text/javascript">

window._ = require('lodash');

import ClientCard from './Card.vue'; 
import AlertFail from '../alert/Fail.vue';
import AlertMessage from '../alert/Message.vue';
import AlertLoading from '../alert/Loading.vue';

export default { 

//------------------------------------------------------
// CHILD COMPONENTS:
//------------------------------------------------------
    components:{
        'alert-fail': AlertFail,
        'client-card': ClientCard,
        'alert-message': AlertMessage,
        'alert-loading': AlertLoading
    },
//------------------------------------------------------
// PROPERTIES:
//------------------------------------------------------
	props: {
		init:{
			type: Boolean,
			default: true,
			required: false
		}
	},
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function () {  
        return {
            list: '',
            selectedCard: '',

            isPaginateAble: true,
            next_page: '',
            first_page: '',
            current_page: '',

            alert_fail: {
                state: false,
                message: ''
            },
            alert_message: {
                state: false,
                message: ''
            },
            alert_loading: {
                state: false,
                message: '',
            }
        }
    },
//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
    methods: {   
    //--------------------------------------------------
    // ALERT COMPONENT
    //--------------------------------------------------
        alert: function(type, message = false) {
            this[type].state = true;
            this[type].message = message;
            this.alertClose(type);
        },   
        alertClose: function(alert) { 
            let vi = this;
            Event.listen('close_'+alert, function() {
                vi[alert].message = '';
                vi[alert].state = false;
            });
            
        },        
    //--------------------------------------------------
    // SCROLL EVENTS
    //--------------------------------------------------
        createScroll: function() {
            window.addEventListener('scroll', this.handleScroll);

        },
        handleScroll: function() {
            if(this.isPaginateAble){
                let current_height = window.innerHeight + window.scrollY;
                let desired_height = document.body.offsetHeight;

                if(current_height >= desired_height)  {
                    this.alert('alert_loading');
                    this.nextListLoad();
                } 
            }

        },
        removeScroll: function() {
            window.removeEventListener('scroll', this.handleScroll);

        },
    //--------------------------------------------------
    // PAGINATION
    //--------------------------------------------------
        paginate: function(first, next, prev) {
            this.next_page = next; this.prev_page = prev; this.first_page = first;
            
        },
        refreshList: function() { 
            this.loadList();
                
        },
    //--------------------------------------------------
	// HTTP REQUESTS
    //--------------------------------------------------
        loadList: function() {
            if(this.init){
                let vi = (this);
                axios.get('/api/clients')
                    .then( function(response) { 
                        vi.list= response.data.data;
                        if(vi.list) {
                            vi.paginate(response.data.first_page_url, response.data.next_page_url,response.data.prev_page_url) ;
                        }else{ 
                            vi.alert('alert_message', 'nothing to show here.');
                        }

                    })
                    .catch( function(error) { 
                        vi.alert('alert_fail', 'We could not retrieve all your clients at this time.');  
                        console.log("ConsultList.loadList(); Error: " + error.response);
                    });
            }
        },
        deleteClient: function(val) {
            let vi = this;
            let ref = val.ref;
            let item = val.index;
            axios.delete('/api/clients/'+ ref)
                .then( function(response) {
                    vi.list.splice(item, 1);

                })
                .catch( function(error){
                    vi.alert('alert_message', 'We could remove this client record');
                    console.log("ConsultList.deleteClient(); Error: " + error.response);
                    
                });

        },
        searchClient: function(val) {
            window.scroll(0,0);
            let vi = this;
            //----------------------------------------------------------------------
            vi.list = []; // empty out list in order to avoid vue js dom rendering.
            vi.isPaginateAble = false; // stop pagination on scroll.  
            vi.alert_message.state = false; // a-null alert_message component.
            //----------------------------------------------------------------------
            if(val.query.length > 0){ // Only perform search in query in not empty.
                axios.get(val.route + val.query)
                    .then( function(response) {
                     vi.list = [];
                        if(response.data.length == 0){
                            vi.alert('alert_message', 'Client does not show in our records.');
                        
                        }else{
                            vi.list = response.data;
                            vi.alert_message.state = false; // a-null alert_message component.
                        }
                    })
                    .catch( function(error) {   
                        vi.alert('alert_message', 'We could not search for that client at this time.');
                        console.log("ConsultList.searchClient(); Error: " + error.response);
                    });
  
            }else{ // If search query is empty return simple list.
                vi.alert_message.state = false;
                vi.isPaginateAble = true;
                vi.loadList();

            }

        },
        nextListLoad:  function() {
            let vi = this;
            axios.get(vi.next_page)
                .then( function(response) {
                    vi.paginate(response.data.first_page_url, response.data.next_page_url,response.data.prev_page_url);
                    let results = response.data.data;
                    vi.alert_loading.state = false;
                    if(results.length > 0){
                        let results_size = response.data.data.length;
                        for(let pointer = 0; pointer < results_size; pointer++){
                            vi.list.push(results[pointer]);
                        }
                    }

                })
                .catch( function(error) {
                    console.log("ConsultList.nextListLoad(); Error: " + error.response);

                });

        },
    //--------------------------------------------------
	// EVENT HANDLING
    //--------------------------------------------------
        onSearchClient: function() {
            let vi = this;
            Event.listen('onSearchClient', function(query) {
                vi.searchClient(query);
            })

        },
        onRefreshList: function() {
            let vi = this;
            Event.listen('onRefreshList', function() {
                vi.refreshList();
            });

        },
        onRemoveClient: function() {
            let vi = this;
            Event.listen('onRemoveClient', function(client) {
                vi.deleteClient(client);
                Event.fire('onAsideNav', 
                    {   
                        client: {
                            ref: '',
                            name: '',
                        },
                        submenu: {
                            clients: true,
                        }
                    }
                );
            })

        },
        onSelectClient: function() {
            let vi = this;
            Event.listen('onSelectClient', function(client) {
                vi.selectedCard= client.ref;
                Event.fire('onAsideNav', 
                    {
                        client: {
                            ref: client.ref,
                            name: client.name,
                        },
                        submenu: {
                            clients: true,
                        }
                    }
                );
                
            });

        },
        listenOnNewConsultation: function() {
            let vi = this;
            Event.listen('onNewConsultation', function() {
                 vi.list = null;
                setTimeout( function() {
                    vi.refreshList();
                }, 100);
            });
        },
    },
//------------------------------------------------------
// LIFECYCLE HOOKS:
//------------------------------------------------------
    created: function() {
        this.loadList();
        this.createScroll();
        this.onRemoveClient();
        this.onRefreshList();
        this.onSelectClient();
        this.onSearchClient();
        this.listenOnNewConsultation();
    }, 
    mounted: function() {
        Event.fire('onAsideNav', 
            {
                client: {
                    ref: '',
                    name: '',
                },
                submenu: {
                    clients: true,
                }
            }
        );
    },
    destroyed: function() {
        this.removeScroll();

    }
}
</script>

// CLIENT LIST STYLING
<style type="scoped">

</style




