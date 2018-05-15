
<template>

    <div class="list-group">
        
        <li
            class="list-group-item bg-light text-dark font-weight-bold ls-05 pl-2">
            <i class="fa fa-list-alt " aria-hidden="true"></i> Other Appts & Events
        </li>
        <li 
            :key="record.id"
            v-for="(record,index) in records" 
            class="list-group-item list-group-item-action pl-4 list-group-item-warning py-0 py-md-2">

            <div class="gfe-text-primary"> -{{ record.title != null ? record.title : '' }} </div> 

            <div class="pl-4"> This reminder is scheduled for {{ $moment(record.time, 'HH:mm:ss').format('h:mm a') }}. </div>

            <div class="pl-4"> {{ apptDescription(index) }}</div>

        </li>
    </div>
  
</template>

<script>
export default {
    props:{
        records:{
            type: Array,
            required: true
        }
    },
    methods:{
        apptDescription: function(index){
            const descrip = this.records[index].description;
            if(descrip != null){
                return "Here are some of your notes for this reminder \"" + descrip + "\" ";
            }
        }
    }
}
</script>