//COMPONENT TEMPLATE
<template>
<!-- Modal Wrapper-->
   <div 
        :id="modalId"
        role="dialog" 
        tabindex="-1"
        aria-hidden="true"
        class="modal fade bd-example-modal-sm"
    >
    <!-- Modal Main-->
        <div class="modal-dialog modal-sm d-flex align-items-center h-100p mwidth mx-auto">
        <!-- Modal Content -->
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-dark">
                <!-- Event Header -->
                    <h5 class="modal-title text-white">
                        <i class="fa fa-calendar text-light-primary" aria-hidden="true"></i>
                        Event Editor
                    </h5>
                <!-- Close Modal -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!-- Modal Body -->
                <div :class="{'bg-light-danger' : !success }" class="modal-body">

                <!-- Event Types -->
                    <div class="d-flex  flex-column justify-content-center">

                <!-- EVENT TYPES: -->

                    <!-- Custom Event Form -->
                        <transition name="fade">
                                <custom-event-form
                                    :fields="customEditor" 
                                    :edit="views.custom"
                                ></custom-event-form>
                        </transition>

                    <!-- Consultation Event Form-->
                        <transition name="fade">
                                <consult-event-form 
                                    :fields="consultEditor"
                                    :edit="views.consultation"
                                ></consult-event-form>
                        </transition>
                        
                    </div>

                </div><!-- ../Modal Body -->
            </div><!-- ../Modal Content -->
        </div> <!-- ../Modal Main -->
    </div> <!-- ../Modal Wrapper -->
</template>

// COMPONENT
<script>

//Event Editor 
import CustomEventForm from './CustomEventForm';
import ConsultEventForm from'./ConsultEventForm';

export default {

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------
    components: {
        'custom-event-form': CustomEventForm,
        'consult-event-form': ConsultEventForm,
    },
//------------------------------------------------------
// REACTIVE DATA
//------------------------------------------------------  
    data: function() {
        return {
            views: {
                custom: false,
                consultation: false
            },
            consultEditor: {},
            customEditor: {},
            success: false,
            modalId: 'event-editor',
        }
    },
//------------------------------------------------------
// COMPONENT METHODS
//------------------------------------------------------
    methods:{
        resetEventsForm: function(originalEventObj){
            this.broadCastOnConsultEventFormReset();
            this.broadCastOnCustomEventFormReset();

        },
        selectEventType: function(eventClick){
            const vi = this;
            for(let prop in vi.views){
                if(prop == eventClick.eventType){
                    vi.views[prop] = true;
                }else{
                    vi.views[prop] = false;
                }
            }

        },
    //--------------------------------------------------
	// BROADCAST & LISTEN TO EVENTS
    //--------------------------------------------------
        listenOnEventDrop: function(){ 
            const vi = this;
            Event.listen('onEventDrop', function(originalEventObj){
                if(originalEventObj.eventType == 'consultation'){
                    Event.fire('onConsultEventFormAlter', originalEventObj);
                }else if( originalEventObj.eventType == 'custom'){
                    Event.fire('onCustomEventFormAlter', originalEventObj);
                }
            });

        },
        listenOnEventClick: function(){
            const vi = this;
            Event.listen('onEventClick', function(originalEventObj){
                vi.resetComponent();
                vi.resetEventsForm(originalEventObj);
                vi.consultEditor = originalEventObj;
                vi.customEditor = originalEventObj;
                vi.selectEventType(originalEventObj); // choose event type to open
                setTimeout( function(){
                    $('#'+vi.modalId).modal('toggle'); 
                },300);
            });
            
        }, 
        listenOnEventRemove: function(){
            const vi = this;
            Event.listen('onConsultEventRemove', function(eventId){
                vi.success = true;
                vi.broadCastOnRemoveEvents(eventId);
            });
            Event.listen('onCustomEventRemove', function(eventId){
                vi.success = true;
                vi.broadCastOnRemoveEvents(eventId);
            });

        },
        listenOnEventUpdate: function(){ 
            const vi = this;
            Event.listen('onConsultEventUpdate', function(originalEventObj){
                vi.success = true;
                vi.broadCastUpdateEvent(originalEventObj);
            });
            Event.listen('onCustomEventUpdate', function(originalEventObj){
                vi.success = true;
                vi.broadCastUpdateEvent(originalEventObj);
            });

        },
        broadCastUpdateEvent: function(originalEventObj){
            Event.fire('onUpdateEvent', originalEventObj);

        },
        broadCastOnRemoveEvents: function(eventId){
            Event.fire('onRemoveEvents', [eventId]);

        },
        broadCastOnCustomEventFormReset: function(){
            Event.fire('onCustomEventFormReset');

        },
        broadCastOnConsultEventFormReset: function(){
            Event.fire('onConsultEventFormReset');
            
        },
    //--------------------------------------------------
	// COMPONENT RESET
    //--------------------------------------------------
        resetComponent: function(){
            Object.assign(this.$data, this.$options.data());

        }
    },
    mounted: function(){
        this.listenOnEventDrop();
        this.listenOnEventClick();
        this.listenOnEventRemove();
        this.listenOnEventUpdate();
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


