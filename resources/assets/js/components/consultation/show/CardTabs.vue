<template>
    <div class="card border-secondary db-border-secondary mb-5 min-300">
    <!-- card-header -->
        <div class="card-header bg-secondary">
        <!-- sizeer -->
            <h5 class="position-corner">
                <span class="badge badge-light">
                    Consultation #{{ numberOfVisits }}
                </span>
            </h5>
        <!-- navigation -->
            <ul class="nav nav-tabs card-header-tabs">

                <li class="nav-item">
                    <a  @click.stop.prevent="selectNav('afternote')" 
                        :class="{'active text-primary': nav.afternote}"
                        
                        class="nav-link font-weight-bold text-white ls-05" href="#"
                    >
                        <span :class="{'gfe-on': nav.afternote}">
                            After Note
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a  @click.stop.prevent="selectNav('service_details')" 
                        :class="{ 'active text-primary': nav.service_details}"

                        class="nav-link text-white font-weight-bold ls-1" href="#"
                    >
                        <span :class="{'gfe-on': nav.service_details}">
                            Services
                        </span>
                    </a>
                </li>

            </ul>
        </div><!-- ../card-header -->
    <!-- card-body -->
        <div class="card-body py-0 px-0">

            <afternote-tab :record="consultation" :display="nav.afternote"> </afternote-tab>

            <services-tab :reference="consultation.id" :display="nav.service_details"> </services-tab>

        </div>
    </div>


</template>

<script type="text/javascript">

// dependencies.
import ServicesTab from './ServicesTab.vue';
import AfterNoteTab from './AfterNoteTab.vue';

export default {

    components: {
        'services-tab': ServicesTab,
        'afternote-tab': AfterNoteTab
    },

    props: {
        consultation: {
            default: '',
            type: [Object,String],
            required: true
        },
        size: {
            type: [Number],
            required: true
        },
        index: {
            type: [Number],
            required: true
        }
    },

    computed: {
        numberOfVisits: function() {
            return Number(this.size) - Number(this.index);
        }
    },

    data: function() {
        return {
            highlight: false,
            nav: {
                afternote: true,
                service_details: false
            },
        }
    },

    methods: {
        select: function(val){
            this.highlight  = val;
        },
        toggleTab: function(tab) {
            let nav = this.nav;
            for(let prop in nav){
                if(prop == tab){
                    setTimeout( function() {
                        nav[prop] = true;
                    }, 500);
                }else{
                    nav[prop] = false;
                }
            }   
        },
        selectNav: function(tab) {
            this.toggleTab(tab);
            
        }
    },

    created: function() {
        //
    }
}

</script>

//STYLING
<style scoped>
    .min-350{
        min-height: 300px !important;
    }
    .db-border-secondary {
        border-bottom: 3px solid #868e96 !important;
    }
    .gfe-on {
        border-bottom: 3px solid #ff6666;
    }
    .position-corner {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>






