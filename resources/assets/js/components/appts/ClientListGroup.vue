
// COMPONENT TEMPLATING
<template>
    <div>
        <transition name="bounce">
            <alert-banner 
                listenOn="AlertBanner"
                :state="views.alertBanner.state"
                :alertClass="views.alertBanner.class">
                <strong v-html="views.alertBanner.message"></strong>
            </alert-banner>
        </transition>

        <transition-group name="list">
            <div v-for="(item,index) in list" :key="item.id">
                <client-list-item
                    :visit="numberOfAppts(index)"
                    :index="index"
                    :record="item"
                ></client-list-item>
            </div>
         </transition-group>
    </div>
</template>

// COMPONENT JAVASCRIPT
<script>

import ClientListItem from './ClientListItem.vue';
import AlertBanner from '../alert/banners/Custom.vue';

export default {

    components: {
        'alert-banner': AlertBanner,
        'client-list-item': ClientListItem
    },

    data: function(){
        return {
            list: '',
            client: '',
            views: {
                alertBanner: {
                    state: false,
                    class: '',
                    message: '',
                }            
            }
        }
    },

    props:{
        records: {
            type: [String,Object],
            required: false
        }
    },

    methods: {
        numberOfAppts: function(index){
            return Number(this.list.length) - index;
        },
        broadCastOnAsideNav: function(){
            const vi = this;
            Event.fire('onAsideNav', {
                client: {
                    ref: vi.client.id,
                    name: (vi.client.first_name + ' ' + vi.client.last_name)
                },
                submenu: {
                    clients: true,
                    appointments: true
                }
            });
        },
        listenOnClientApptUpdate: function(){
            const vi = this;
            Event.listen('onClientApptUpdate', function(){
                vi.verifyList(vi.list);
                vi.views.alertBanner.state = true;
                vi.views.alertBanner.class = "alert-warning mx-auto rounded posit-top";
                vi.views.alertBanner.message = 'FYI: These changes will take immediate affect on your main calendar, thank you!';
                setTimeout( function(){
                    vi.views.alertBanner.state = false;
                    vi.views.alertBanner.class = "";
                    vi.views.alertBanner.message = "";
                }, 10000);
            });
        },
        listenOnClientApptRemove: function(){
            const vi = this;
            Event.listen('onClientApptRemove', function(index){
                vi.views.alertBanner.state = true;
                vi.views.alertBanner.class = "alert-warning mx-auto rounded posit-top";
                vi.views.alertBanner.message = 'FYI: These changes will take immediate affect on your main calendar, thank you!';
                setTimeout( function(){
                    vi.views.alertBanner.state = false;
                    vi.views.alertBanner.class = "";
                    vi.views.alertBanner.message = "";
                }, 10000);
            });
        },
        verifyList: function(list){
            const vi = this;
            if(list.length == 0){
                vi.views.alertBanner.state = true;
                vi.views.alertBanner.class = 'alert-info mx-auto rounded posit-top h6';
                vi.views.alertBanner.message = '<i class="mb-1 fa fa-question-circle fa-lg text-primary"></i> There are no appointments set for this client... <br/> <div class="pl-5">To set an appointment please head over <a href="/master-calendar/" class="alert-link text-primary">to your calendar.</a></div>';
            }
        }
    },

    created: function(){
        this.listenOnClientApptUpdate();
        this.listenOnClientApptRemove();
    },

    mounted: function(){
        const parsed = JSON.parse(this.records);
        this.client = parsed.client;
        this.list = parsed.appts;

        this.verifyList(this.list);
        this.broadCastOnAsideNav();
    }
}
</script>


// COMPONENT STYLING
<style scoped>
    .posit-corner{
        position: absolute;
        left: -6px;
        top: 0px;
        height: 100%;
        font-size: 145% !important;
    }
    .posit-top{
        position: sticky;
        z-index: 1000;
        width: 85%;
        top: 75px;
    }
</style>


