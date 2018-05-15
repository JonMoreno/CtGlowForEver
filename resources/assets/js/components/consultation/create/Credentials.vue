//TEMPLATE 
<template>
    <div class="card mt-2 mb-2 no-border">
        <div class="card-body py-2 px-2">
            <!-- card-title: client full name -->
                <h5 class="card-title gfe-text-red mb-1">
                    <i class="fa fa-user text-fancy-dark"></i>
                    <span v-if="reference.name">
                        {{reference.name}}
                    </span>
                    <span v-else>
                        {{ reference.first_name + ' ' + reference.last_name }}
                    </span>
                </h5>
                <!-- help-info -->				
                
                <small class="card-sub-title text-muted "> 
                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                    Please, fill in for today's consultaion
                </small>
        </div>
    </div>
</template>

//COMPONENT   
<script type="text/javascript">
export default {
    props: {
        reference: {
            default: '',
            required: true,
            type: [String, Object],
        }
    },

    methods: {
        
    }
}
</script>