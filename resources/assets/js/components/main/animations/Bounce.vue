<template>
    <transition name="bounce">
        <div v-if="views.animate">
            <slot></slot>
        </div>
    </transition>
</template>


<script>

export default {
    props:{
        view: {
            type: Boolean,
            required: true
        }
    },

    data(){
        return{
            views:{
                animate: '',
            }
        }
    },

    created(){
        this.views.animate = this.view;
    },

    mounted(){
        const vi = this;
        vi.views.animate = true;
    }
}
</script>
