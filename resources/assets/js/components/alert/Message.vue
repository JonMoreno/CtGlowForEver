//TEMPLATE 
<template>

    <div v-if="state" class="alert bg-light-primary text-fancy-dark text-center">
			<slot>
					<strong>Holy guacamole!!!</strong> Something went wrong...
					
			</slot>
        	    
            <button type="button" class="close" v-on:click="broadcast_fail()">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

</template>


//COMPONENT 
<script type="text/javascript">
    export default {
	props: {
	    state: {
		type: Boolean,
		required: true,
	    }
	},
	methods: {
	    broadcast_fail: function(){
			Event.fire('close_alert_message');
	    }
	}
	
    }

</script>