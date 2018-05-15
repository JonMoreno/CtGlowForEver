//TEMPLATE 
<template>
    <div v-if="state"  class="alert alert-warning" role="alert">

        <button type="button" class="close" v-on:click="broadCastOnCloseAlert()">
                <span aria-hidden="true">&times;</span>
        </button>

        <h4 class="alert-heading">
            <slot name="alert-header"></slot>
        </h4>

        <p>
            <slot name="alert-body"></slot>
        </p>

        <hr>

        <p class="mb-0">
            <slot name="alert-footer"></slot>
        </p>

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
	    broadCastOnCloseAlert: function(){
			Event.fire('onCloseAlertWarning');
	    }
	}  
}
</script>