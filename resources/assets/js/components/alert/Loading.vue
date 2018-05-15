//TEMPLATE 
<template>

<div>
    <div v-show="state" class="alert alert-light text-center" role="alert">
        <div class="display-1">
        	    <i class="fa fa-spinner fa-pulse"></i>
        </div>
        <hr>
        <p class="mb-0">
        	    Loading...
        </p>
    </div>
</div>

</template>


//COMPONENT 
<script type="text/javascript">
    export default {
	props: {
	    state: {
		type: Boolean,
		require: true,
	    }
	},
    
    }

</script>


//STYLE
<style scoped>

</style>