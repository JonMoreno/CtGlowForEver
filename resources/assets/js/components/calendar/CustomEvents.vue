// COMPONEMT TEMPLATE
<template>
  
</template>

// COMPONENT JAVASCRIPT
<script type="text/javscript">

export default {

//------------------------------------------------------
// COMPONENT REACTIVE DATA:
//------------------------------------------------------  
    data: function(){
        return {
            route: '/api/calendar-customs',
            events: '',
            default: {
                color: '#bee5eb',
                textColor: '#2c3e50'
            }
        }
    },
//------------------------------------------------------
// COMPONENT METHODS:
//------------------------------------------------------
    methods:{
    //--------------------------------------------------
    // HTTP REQUESTS
    //--------------------------------------------------
        getCustomEvents: function(){
            const vi = this;
            axios.get(vi.route)
                .then( function(response){
                    vi.events = vi.eventSourceTransform(response.data, vi.default.color, vi.default.textColor);
                    vi.broadCastOnAddEventSource(vi.events);
                })
                .catch( function(error){
                    const msg = 'CustomEvents.getCustomEvents(); Error' + error;
                    vi.broadCastOnFullCalendarFail(msg);
                })
        },
    //--------------------------------------------------
    // EVENT TRANSFORM (fullcalendar)
    //--------------------------------------------------
        eventSourceTransform: function(rawEvents, bgColor = '', textColor = ''){
            const vi = this; const eventSource = [];

            for(let index in rawEvents){
                const eventObj = {   
                    eventType: 'custom',
                    // event context.
                    id: rawEvents[index].id,
                    title: rawEvents[index].title,
                    description: rawEvents[index].description,
                    // event date&time.
                    allDay: rawEvents[index].time ? false : true,
                    time: vi.formatEventTime(rawEvents[index].time),
                    start: vi.formatEventStart(rawEvents[index].date, rawEvents[index].time),
                    // event styiling.
                    color: bgColor,
                    textColor: textColor,
                    durationEditable: false ,
                }
                eventSource.push(eventObj);
            }
            return eventSource;
        },
    //--------------------------------------------------
    // EVENT DATA MUTATION
    //--------------------------------------------------
        formatEventTime: function(time){
            if(time !== null){
                return this.$moment(time, 'HH:mm:ss').format('HH:mm');
            }
            return null; 
        },
        formatEventStart: function(date, time){
            return this.$moment(date + time, 'YYYY-MM-DD HH:mm');

        },
    //--------------------------------------------------
    // BROADCAST & LISTEN (events)
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
        this.getCustomEvents();

    }
}
</script>
