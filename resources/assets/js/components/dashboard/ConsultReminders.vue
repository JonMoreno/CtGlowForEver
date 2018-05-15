
<template>

    <div class="list-group">
        
        <li
            class="list-group-item bg-light text-dark font-weight-bold ls-05 pl-2">
            <i class="fa fa-list-alt " aria-hidden="true"></i> Client Appts.
        </li>
        <li 
            :key="record.id"
            v-for="(record,index) in records" 
            class="list-group-item list-group-item-action pl-4 list-group-item-warning py-0 py-md-2">
            <a  tabindex="0" 
                role="button" 
                v-if="$moment().format('MM-DD') == $moment(record.client.dob, 'MM-DD-YYYY').format('MM-DD')"
                data-trigger="focus" 
                data-placement="top"
                data-toggle="popover" 
                title="Birthday Reminder" 
                class="btn btn-light gfe-text-red border-light-secondary py-0 px-1" 
                data-content="Today is your client's birth day. Please, express to them your best whishes!">
                <i class="fa fa-gift gfe-text-red fa-lg" aria-hidden="true"></i>
            </a>
            <client-dropdown :credentials="record.client"></client-dropdown>

            <div class="pl-4"> {{ heOrShe(index) }} {{ scheduledMsg(index) }}</div>

            <div class="pl-4"> {{ apptDescription(index) }}</div>

        </li>
    </div>
  
</template>

<script>

const moment =  require('moment');
import ClientDropDown from './ClientCredentials.vue';

export default {
    components:{
        'client-dropdown': ClientDropDown
    },

    props:{
        records:{
            type: Array,
            required: true
        }
    },

    computed: {
        isBirthDay: function(){
			if(Moment().format('MM-DD') == Moment(this.client.dob, 'MM-DD-YYYY').format('MM-DD')){
				return true;
			}
			return false;
		}
    },

    methods:{
        heOrShe: function(index){
            const gender = this.records[index].client.gender;
            if(gender == 'female'){
                return 'She';
            }else{
                return 'He';
            }
        },
        hisOrHer: function(index){
            const gender = this.records[index].client.gender;
            if(gender == 'female'){
                return 'her';
            }else{
                return 'his';
            }
        },
        apptDescription: function(index){
            const descrip = this.records[index].consults.description;
            if(descrip != null){
                return "Here are some of your notes for this appt \"" + descrip + "\" ";
            }
        },
        scheduledMsg: function(index){
            const vi = this;
            if(vi.records[index].consults.time != null){
                return 'is scheduled to come in at ' + moment(vi.records[index].consults.time, 'HH:mm:ss').format('h:mm a') + '.';
            }else{
                return 'does not have a specific time for ' + vi.hisOrHer(index) + ' appointment.';
            }
        }
    }
    
}
</script>

<style scoped>
    .link-up{
        position: relative;
        bottom: 2px;
    }
    
</style>




