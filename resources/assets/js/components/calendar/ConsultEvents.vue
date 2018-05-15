<template></template>

// component
<script>
//------------------------------------------------------
// DEPENDENCIES:
//------------------------------------------------------
const moment = require('moment');

export default {
//------------------------------------------------------
// COMPONENT REACTIVE DATA:
//------------------------------------------------------
    data: function() {
        return {
            route: '/api/calendar-consultations',
            events: '',
            default: {
                color: '#b8daff',
                textColor: '#2c3e50'
            },
            moment: moment,
        }
    },
//------------------------------------------------------
// COMPONENT METHODS:
//------------------------------------------------------
    methods:{
    //--------------------------------------------------
	// HTTP REQUESTS
	//--------------------------------------------------
        getConsultEvents: function(){
            const vi = this;
            axios.get(vi.route)
                .then( function(response){
                    vi.events = vi.eventSourceTransform(response.data, vi.default.color, vi.default.textColor);
                    vi.broadCastOnAddEventSource(vi.events);// FullCalendar
                })
                .catch( function(error) {
                    let msg = 'ConsultationEvents.getConsultEvents()' + error;
                    vi.broadCastOnFullCalendarFail(msg);
                }); 

        },
    //--------------------------------------------------
	// DATA MANIPULATION
    //--------------------------------------------------
        eventTimeTransform: function(time){
            if(time !== null){
                return moment(time, 'HH:mm:ss').format('HH:mm');
            }else{
                return null;
            }
        },
        eventDateTimeTransform: function(date, time = false){
            return moment(date + time, "YYYY-MM-DD HH:mm"); 

        },
    //--------------------------------------------------
	// EVENT TRANSFORMATION
    //--------------------------------------------------
        eventSourceTransform: function(consultations, color = '', textColor = '') {
            let vi = this; let events = [];

            for(let i in consultations){
                let elTitle; let elRef; let elFirstName; let elLastName; 
                
                for(let y in consultations[i].client){
                    elTitle = consultations[i].client.first_name + ' ' +consultations[i].client.last_name;
                    elRef =  consultations[i].client.id,
                    elFirstName = consultations[i].client.first_name;
                    elLastName = consultations[i].client.last_name;
                }
                let event = {
                    // Required Props:
                    id: consultations[i].id,
                    start: vi.eventDateTimeTransform(consultations[i].date, consultations[i].time),
                    allDay: consultations[i].time ? false : true,
                    description: consultations[i].description,
                    title: elTitle,
                    color: color,
                    textColor: textColor,
                    durationEditable: false,
                    //Custom Props
                    time: vi.eventTimeTransform(consultations[i].time),
                    eventType: 'consultation',
                     client: {
                        id: elRef,
                        first_name: elFirstName,
                        last_name: elLastName,
                    },
                };
                events.push(event);
            }
            return events;
        },
    //--------------------------------------------------
	// BROADCASTING EVENTS
    //--------------------------------------------------
        broadCastOnAddEventSource: function(source){
            Event.fire('onAddEventSource', source);
            
        },
        broadCastOnFullCalendarFail: function(error){
            Event.fire('onFullCalendarFail', error);

        }
    },
//------------------------------------------------------
// COMPONENT LYFECYCLE HOOKS:
//------------------------------------------------------
    created: function(){
        this.getConsultEvents();

    }
}
</script>

