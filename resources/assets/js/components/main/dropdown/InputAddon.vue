

// COMPONENT TEMPLATING
<template>
    <div :class="inputAddonDropVariation">
        <button 
            type="button" 
            :class="buttonClass"
            aria-expanded="false"
            data-toggle="dropdown" >
           
            <slot name="btn-title">
                Button Title
            </slot>

        </button>
        <div class="dropdown-menu">

            <slot name="drop-menu">
                DropDonw Menu
            </slot>

        </div>
    </div>
</template>


// COMPONENT JAVASCRIPT
<script>

export default {
    props:{
        addon: {
            type: String,
            required: true
        },
        drop: {
            type: String,
            required: true
        },
        btnClass: {
            type: String,
            required: true
        }
    },
    computed: {
        inputAddonDropVariation: function(){
            return "input-group-" + this.addon + ' ' + this.drop;
        },
        buttonClass: function(){
            return  "btn " + this.btnClass + " right-round dropdown-toggle";
        }
    }
}
</script>

<style scoped>
    .dropdown-toggle::after {
        display:none
    }
    
</style>

