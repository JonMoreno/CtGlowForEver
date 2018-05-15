//TEMPLATE 
<template>
    <div v-if="state" class="card" >
        <div class="card-body text-center pt-3">

            <div class="text-center display-2">
                <i class="fa fa fa-exclamation-circle fa-lg text-danger" aria-hidden="true"></i>
            </div>
            
            <slot>
                <div>
                    <h4>Oops!</h4>
                    <p class="lh-1 mb-0">
                            Well, this is embarassing...
                            <br/>
                            Please, refresh your window. If the problem continues contact your developer.
                            <br/>
                        <small>
                            <a  href="mailto:jon-moreno@outlook.com">JonNathan Moreno </a>
                        </small>
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
