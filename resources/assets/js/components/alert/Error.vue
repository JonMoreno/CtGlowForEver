//TEMPLATE 
<template>

<div>
    <div v-show="state" class="alert alert-danger text-center" role="alert">
        <div class="display-1">
        	    <i class="fa fa-exclamation-circle text-danger" aria-hidden="true fa-2x"></i>
        </div>
        <hr>
        <p class="mb-0">
        	    Well, this is embarassing...
        	    <br/>
        	    Please, refresh your window. If the problem continues contact your developer.
        	    <br/>
            <small>
                <a  href="mailto:jon-moreno@outlook.com">JonNathan Moreno </a>
        	    </small>
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