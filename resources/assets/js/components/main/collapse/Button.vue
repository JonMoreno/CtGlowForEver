

// COMPONENT TEMPLATING
<template>
    <div>
    <!-- Button -->
        <div class="clearfix">
            <a  role="button"
                :href="hrefBuild()"
                aria-expanded="false"
                data-toggle="collapse"
                :class="buttonClassBuild()">
                <small>
                    <i class="fa fa-plus-circle"></i>
                    {{  buttonTitle }}
                </small>
            </a>
        </div> 
        <div class="collapse"  :id="referenceBuild()">
            <slot></slot>
        </div>
    </div>
</template>


// COMPONENT JAVASCRIPT
<script>
export default {
    props:{
        refId: {
            type: String,
            required: true
        },
        buttonTitle: {
            type: String,
            required: true
        },
        buttonClass: {
            type: String,
            required: true
        }
    },
    methods:{
        hrefBuild: function(){
            return '#'+ this.refId;
        },
        
        referenceBuild: function(){
            return this.refId;
        },
        buttonClassBuild: function(){
            return "btn " + this.buttonClass;
        },
        listenOnCollapse: function(){
            let vi = this;
            Event.listen('onCollapse'+ this.refId, function(refId){
                $("#"+refId.selector).collapse(refId.action);
            })
        }
    },
    mounted: function(){
        let vi = this;
        this.listenOnCollapse();
    }
}
</script>

