//TEMPLATE 
<template>
    <div v-if="state" class="card" >
        <div class="card-body text-center pt-3">
            <div class="text-center display-2">
                <i class="fa fa-check-circle-o fa-lg text-success" aria-hidden="true"></i>
                
            </div>
            <slot>
                <div>
                    <h4>Great!</h4>
                    <p class="lh-1">Now, every
                        <br/>detail has been saved!
                    </p>
                </div>
            </slot>
        </div>
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

	}  
}
</script>

<style scoped>

</style>
