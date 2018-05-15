//TEMPLATE 
<template>
    <div v-if="state" :class="alertClassType">
		<button type="button" class="close pull-right" @click=" state = false">
			<span aria-hidden="true">&times;</span>
		</button>
		<slot>
				<strong>Holy guacamole!!!</strong> Something went wrong...
				
		</slot>   
			
		
    </div>
</template>


//COMPONENT 
<script type="text/javascript">
export default {
  
	props: {
	    state: {
			type: Boolean,
			required: true,
	    },
		alertClass:{
			type: String,
			required: true
		},
		listenOn:{
			type: String,
			required: true
		}
	},

	computed: {
		alertClassType: function(){
			return 'alert ' + this.alertClass;
		}
	},

	created: function(){
		const vi = this;
		Event.listen('on' + vi.listenOn, function(bool){
			vi.state = bool
		})
	}
}

</script>

<style scoped>
	.posit-top-corner{
		position: absolute;
		right: 15px;
		top: 0px;
	}
</style>
