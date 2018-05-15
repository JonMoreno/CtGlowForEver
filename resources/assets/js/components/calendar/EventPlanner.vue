//COMPONENT TEMPLATE
<template>
<!-- Modal Wrapper-->
   <div :id="modalId" role="dialog" tabindex="-1" aria-hidden="true" class="modal fade bd-example-modal-sm mx-auto">
    <!-- Modal Main-->
        <div class="modal-dialog modal-sm d-flex align-items-center h-100p mwidth">

        <!-- Modal Content -->
            <div class="modal-content">

            <!-- Modal Header -->
                <div class="modal-header bg-dark">
                <!-- Event Header -->
                    <h5 class="modal-title text-white">
                        <i class="fa fa-calendar text-light-primary" aria-hidden="true"></i>
                        Event Planner
                    </h5>
                <!-- Close Modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            <!-- Modal Body -->
                <div class="modal-body">

                <!-- Event Planner Events -->
                    <div class="d-flex  flex-column justify-content-center">

                    <!-- Event Type Buttons -->
                        <!-- Button -->
                            <button 
                                type="button"
                                v-if="views.eventBtns"
                                @click="onSelectEvent('customEvent')"
                                class="btn btn-outline-dark btn-sm font-weight-bold mx-3  my-3 text-left ls-1"
                            >
                                <i class="fa fa-calendar-plus-o fa-lg text-light-primary" aria-hidden="true"></i> Custom Event
                            </button>
                        <!-- Button-->
                            <button 
                                type="button"
                                v-if="views.eventBtns"
                                @click="onSelectEvent('consultEvent')" 
                                class="btn btn-outline-dark btn-sm font-weight-bold mx-3 my-3 text-left ls-1">
                                <i class="fa fa-calendar-plus-o fa-lg text-light-primary" aria-hidden="true"></i> 
                                Consultation Apt
                            </button>
                    <!-- ../Event Type Buttons -->

                    <!-- Create Custom Event -->
                        <transition name="fade">
                            <div v-if="views.customEvent">
                            <!-- Custom Event Form -->
                                <custom-event-form
                                    :fields="customPlanner"
                                    :create="views.customEvent">
                                </custom-event-form>
                            </div>
                        </transition>

                    <!-- Create Consult Event -->
                        <!-- Client Search Bar & New Client Form -->
                            <transition name="slide-fade">
                                <div v-if="views.searchBar" @click="views.consultEvent = false" class="mt-4 mb-3">
                                <!-- Search Bar -->
                                    <client-search-bar></client-search-bar>
                                <!-- Dropdown Form -->
                                    <!-- <collapse-tab
                                        :refId="collapseId"
                                        button-title="new client"
                                        button-class="btn-link pull-right px-0 py-0 text-primary"> -->
                                    <!-- Form -->
                                        <!-- <new-client-form ></new-client-form> -->
                                    <!-- ../Form -->
                                    <!-- </collapse-tab> -->
                                </div>
                            </transition>

                        <!-- Consultation Event Form -->
                            <transition name="fade">
                                <div 
                                    v-if="views.consultEvent" >

                                    <consult-event-form 
                                        :fields="consultPlanner" 
                                        :create="views.consultEvent">
                                    </consult-event-form>

                                </div>
                            </transition>
                    <!-- ../Create Event Type -->

                    </div><!-- ../Event Types -->

                </div><!-- ../Modal Body -->
            </div><!-- ../Modal Content -->
        </div> <!-- ../Modal Main -->
    </div> <!-- ../Modal Wrapper -->
</template>

// COMPONENT
<script>

import Moment from 'moment';
import CustomEventForm from './CustomEventForm.vue';
import ConsultEventForm from './ConsultEventForm.vue';

// Child Components
import SearchClient from './SearchClient.vue';
import NewClient from './NewClient.vue';
import CollapseButton from '../main/collapse/Button.vue';

export default {

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components: {
        'client-search-bar': SearchClient,
        'new-client-form': NewClient,
        'collapse-tab': CollapseButton,
        'custom-event-form': CustomEventForm,
        'consult-event-form': ConsultEventForm,
    },
//------------------------------------------------------
// REACTIVE DATA
//------------------------------------------------------  
    data: function() {
        return {
            customPlanner: {
                title: '',
                date: '',
                time: '',
                description: ''
            },
            consultPlanner: {
                client: {},
                title: '',
                date: '',
                time: '', 
                description: '',
            },
            views: {
                searchBar: false,
                eventBtns: true,
                customEvent: false,
                consultEvent: false
            },
            modalId: 'event-planner',
            collapseId: 'NewClientForm'
        }
    },
//------------------------------------------------------
// COMPONENT METHODS
//------------------------------------------------------
    methods:{
        resetEventsForm: function(eventObj){
            this.broadCastOnEventFormReset();
            
        },
        onSelectEvent: function(event){
            const vi = this;
            for(let view in vi.views){
                if(view == event){

                    if(view == 'consultEvent'){
                        vi.views.searchBar = true;
                    }else{
                        vi.views[view] = true;
                    }
                    
                }else{
                    vi.views[view] = false;
                }
            }
            vi.views.eventBtns = false;
             
        },
    //--------------------------------------------------
	// BROADCAST & LISTENT TO EVENTS
    //--------------------------------------------------
        listenOnDayClick: function(){
            const vi = this;
            Event.listen('onDayClick', function(eventOpt){
                console.log(eventOpt);
                vi.resetComponent();
                vi.resetEventsForm();

                if(eventOpt.viewType == 'agendaWeek' || eventOpt.viewType == 'agendaDay'){
                    vi.customPlanner.date = Moment(eventOpt.date, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');
                     vi.customPlanner.time =  Moment(eventOpt.date, 'YYYY-MM-DD HH:mm').format('HH:mm');
                    vi.consultPlanner.date = Moment(eventOpt.date, 'YYYY-MM-DD HH:mm').format('YYYY-MM-DD');
                     vi.consultPlanner.time =  Moment(eventOpt.date, 'YYYY-MM-DD HH:mm').format('HH:mm');

                }else{
                    vi.customPlanner.date = eventOpt.date;
                    vi.consultPlanner.date = eventOpt.date;
                }
                setTimeout( function(){
                    $('#'+vi.modalId).modal('toggle');
                },300);
            });

        },
        listenOnNewClient: function(){
            const vi = this;
            Event.listen('onNewClient', function(){
                vi.broadCastOnCollapseClientForm('hide');
            });
            
        },
        listenOnFindClient: function(){ // Search Client COMP:
            const vi = this;
            Event.listen('onFindClient', function(client){
                vi.consultPlanner.client = client;
                vi.views.consultEvent = true;
            });

        },
        broadCastOnRendedEvent: function(eventObj){
            Event.fire('onRenderEvent', eventObj);

        },
        listenOnEventCreate: function(){
            const vi = this;
            Event.listen('onCustomEventCreate', function(eventObj){ // Custom Event:
                vi.broadCastOnRendedEvent(eventObj);
            });
            Event.listen('onConsultEventCreate', function(eventObj){ // Consult Event:
                vi.views.searchBar = false;
                vi.broadCastOnRendedEvent(eventObj);
            });

        },
        broadCastOnCollapseClientForm: function(hideOrShow){
            let id = this.collapseId;
            Event.fire('onCollapse'+ id, { selector: id , action: hideOrShow});

        },
        broadCastOnEventFormReset: function(){
            Event.fire('onConsultEventFormReset');
            Event.fire('onCustomEventFormReset');

        },
    //--------------------------------------------------
	// COMPONENT RESET
    //--------------------------------------------------
        resetComponent: function(){
            Object.assign(this.$data, this.$options.data());

        }
    },
    mounted: function(){
        this.listenOnDayClick();
        this.listenOnNewClient();
        this.listenOnFindClient();
        this.listenOnEventCreate();

    }
}
</script>

<style scoped>
    .pos-top-left {
        position: absolute;
        top: 0px;
        left: 8px;
    }
    .h-100p{
        height: 100% !important;
    }
    .mwidth{
        /* min-width: 375px !important; */
    }
</style>


