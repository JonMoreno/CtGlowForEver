// COMPONET TEMPLATE
<template>
    <div>
    <!-- Alert Fail -->
        <div v-if="alert_fail" id="alert-fail" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog d-flex align-items-center h-100p mw-350">
                <div class="modal-content">
                    <alert-fail :state="alert_fail"></alert-fail>
                </div>
            </div>
        </div>
        
    <!-- Full Calendar -->
        <div id="calendar"></div>
        <!-- Custom Calendar Events -->
            <custom-events></custom-events>

        <!-- Consultation Calendar Events -->
            <consult-events ></consult-events>

        <!-- Event Editor -->
            <event-editor></event-editor>

        <!-- Event Planner -->
            <event-planner></event-planner>
    </div>
</template>

//COMPONENT
<script>

//------------------------------------------------------
// DEPENDENCIES:
//------------------------------------------------------
import 'fullcalendar';
window._ = require('lodash');
const moment = require('moment');
// Alerts
import AlertIconFail from '../alert/icon/fail.vue';
// Calendar
import EventEditor from './EventEditor.vue';
import EventPlanner from './EventPlanner.vue';
import CustomEvents from './CustomEvents.vue';
import ConsultEvents from './ConsultEvents.vue';  

export default {
/*-------------------------------------------------------
| COMPONENT: Full Calendar
|--------------------------------------------------------
| This component is a implementation for js fullCalendar.
| It will help us do a few things:
|   - Display all current events.
|   - Create future events.
|   - Remove event and alter them.
|
*/

//------------------------------------------------------
// CHILD COMPONENTS
//------------------------------------------------------   
    components: {
        'alert-fail': AlertIconFail,
        'event-editor': EventEditor,
        'event-planner': EventPlanner,
        'custom-events': CustomEvents,
        'consult-events': ConsultEvents,
    },
//------------------------------------------------------
// REACTIVE DATA:
//------------------------------------------------------
    data: function() {
        return {
            calendar: null,
            header: {    
                right: 'month,agendaWeek,agendaDay',
                center: 'title',
                left: 'prev,next today',
            },
            footer:{
                right: 'appointment.'
            },
            alert_fail: false,
        }
    },

//------------------------------------------------------
// INSTANCE METHODS:
//------------------------------------------------------
     methods: { 
            //--------------------------------------------------
	// COMPONENT INIT FUNCTIONS
    //--------------------------------------------------
        initFullCalendar: function() {
            const vi = this;  vi.calendar = $(vi.$el);
            
            vi.calendar.fullCalendar({ 
                //----------------------------------------
                // CALENDAR SETTINGS:
                //----------------------------------------
                eventLimit: 3,
                editable: true,
                height: 'auto',
                header: vi.header,
                contentHeight: 600,
                nowIndicator: true,
                timeFormat: 'h(:mm)t',
                eventColor: '#b8daff',
                displayEventTime: true,
                eventStartEditable: true,
                themeSystem: 'bootstrap4',
                eventTextColor: '#2c3e50',
                //----------------------------------------
                // CALLENDAR EVENT:
                //----------------------------------------
                dayClick: function(date, jsEvent, view) {
                    Event.fire('onDayClick', { date: date.format(), viewType: view.name });

                },
                eventClick: function(eventObj, jsEvent, view){ 
                    Event.fire('onEventClick', eventObj);

                },
                eventAfterRender: function(eventObj, $el) {
                    $el.popover({
                        title: eventObj.title? eventObj.title : '',
                        content: eventObj.description ? eventObj.description : '',
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });

                },
                eventDrop: function(eventObj, delta, revertFunc, jsEvent, ui, view){
                    Event.fire('onEventDrop', eventObj);
                    setTimeout( function(){ $('.popover').popover('hide');},900);

                },
            });
        },
    //--------------------------------------------------
	// EVENT RESPONSE
    //--------------------------------------------------
        renderEvent: function(eventObj){
            this.calendar.fullCalendar('renderEvent', eventObj);

        },
        addEventSource: function(eventSourceObj, removeCurrentEvents = false) {
            if(removeCurrentEvents){
                this.calendar.fullCalendar('removeEvents');
            }
            this.calendar.fullCalendar('addEventSource', eventSourceObj);

        },   
    //--------------------------------------------------
	// BROADCAST & LISTENING TO (EVENTS)
    //--------------------------------------------------
        listenOnRenderEvent: function(){
            const vi = this;
            Event.listen('onRenderEvent', function(eventObj){
                vi.renderEvent(eventObj);
            });

        },
        listenOnRemoveEvents: function(){
            let vi = this;
            Event.listen('onRemoveEvents', function(idArray){
                vi.calendar.fullCalendar('removeEvents', idArray);
            });

        },
        listenOnUpdateEvent: function(){
            const vi = this;
            Event.listen('onUpdateEvent', function(originalEvent){
                vi.calendar.fullCalendar('updateEvent', originalEvent);
            });

        },
        listenOnAddEventSource: function(){ 
            const vi = this;
            Event.listen('onAddEventSource', function(source){
                vi.addEventSource(source);
            });

        },
        listenOnFullCalendarFail: function(){
            const vi = this;
            Event.listen('onFullCalendarFail', function(error){
                vi.alert_fail = true;
                $('#alert-fail').modal('toggle');
                console.log('FullCalendar Error: ' + error);
            });

        },
        broadCastOnAsideNav: function(){
            Event.fire('onAsideNav', {submenu: {calendar: true}});

        }
    },
//------------------------------------------------------
// LYFECYCLE HOOKS:
//------------------------------------------------------
    mounted: function() {
        this.initFullCalendar();
        this.broadCastOnAsideNav();
        this.listenOnRenderEvent();
        this.listenOnUpdateEvent();
        this.listenOnRemoveEvents();
        this.listenOnAddEventSource(); 
        this.listenOnFullCalendarFail();  
    }
}
</script>

// COMPONENT STYLING
<style scoped>
    .h-100p{
        height: 100% !important;
    }
    .mw-350{
        min-width: 350px !important;
    }
</style>

