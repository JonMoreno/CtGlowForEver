//TEMPLATE 
<template>

    <div v-if="state" class="alert alert-danger text-center">
        <slot>
        	    <strong>Holy guacamole!!!</strong> Something went wrong...
        	    
        </slot>
        	    
            <button type="button" class="close" v-on:click="broadCastOnCloseAlertFail()">
                <span aria-hidden="true">&times;</span>
            </button>
            <hr class="mt-0">	
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
	    broadCastOnCloseAlertFail: function(){
			Event.fire('onCloseAlertFail'); //NEW: USE THIS EVENT!!!
			Event.fire('close_alert_fail');
			Event.fire('close_alert');
	    }
	}
	
    }

</script>