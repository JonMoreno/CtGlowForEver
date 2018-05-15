// TEMPLATE
<template>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-11 col-lg-10 mx-auto">
            <transition name="bounce">
                <alert-icon-fail :state="show.alert_fail"></alert-icon-fail>
            </transition>

            <transition-group
                name="custom-classes-transition"
                enter-active-class="animated fadeInDownBig"
                leave-active-class="animated zoomOut"
            >
                <div v-if="consultations" v-for="(consultation, index) in consultations" :key="consultation.id">
                    <card-tabs :consultation="consultation" :index="index" :size="consultations.length"></card-tabs>
                </div>
            </transition-group>

            <transition name="fade">
                <!-- EMPTY LIST -->
                <div v-if="consultations.length == 0" class="list-group">
                    <a class="list-group-item list-group-item-action text-center px-2">
                        <p class="lead">
                            <i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>No Consultations recorded.
                        </p>
                    </a>
                </div>
            </transition>
        </div>
    </div>

</template>

// COMPONENT
<script type="text/javascript">
//dependencies.
import CardTabs from './CardTabs.vue';
import AlertIconFail from '../../alert/icon/fail.vue';


export default {
    components: {
        'card-tabs': CardTabs,
        'alert-icon-fail': AlertIconFail
    },

    props: {
        info: {
            type: String,
            default: '',
            required: false,
        }
    },

    data: function() {
        return {
            client: '',
            show: {
                alert_fail: false,
            },
            consultations: [],
        }
    },

    methods: {
    //http request.
        refreshList: function() {
            let vi = this;
            axios.get('/api/consultations/' + vi.client.id)
                .then( function(response) {
                    vi.consultations = null;
                    vi.consultations = response.data.consultations;
                }).catch( function(error) {
                    vi.show.alert_fail = true;
                });
        },
    //event handling.
        broadCastToAsideNav: function() {
			const id = this.client.id;
			const name = this.client.first_name+' '+this.client.last_name;
			Event.fire('onAsideNav', 
				{ 	
                    client: {
                        ref: id,
                        name: name,
                    },
					submenu: {
						clients: true,
						consultations: true
					},
				}
			);	
        },
        listenOnNewConsultation: function() {
            let vi = this;
            Event.listen('onNewConsultation', function() {
                vi.refreshList();
            });
        } 
    },

    created: function() {
        this.listenOnNewConsultation();

    },

    mounted: function() {
        this.client = JSON.parse(this.info);
        this.consultations = this.client.consultations;
        this.broadCastToAsideNav();
    }
}

</script>