<template>
    <div>
    <transition name="fade">
        <div v-if="views.main" class="card border-light-secondary mb-5">

            <div class="card-body">
                <h5 class="card-title"> 
                    <div class="pull-right gfe-text-primary"><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i>
                        <small class="gfe-text-lred">{{ timeNow }}</small>
                    </div>
                    <div class="pull-left gfe-text-primary">
                        <a @click.stop.prevent="" href="#" id="datepicker"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i></a>
                        <small class="gfe-text-lred">{{ todaysDate }}</small>
                    </div>
                </h5>

            </div> 

            <div class="list-group list-group-flush">
                <li class="list-group-item disabled text-center pt-1 pb-0 py-md-3">
                    <h4 class="ls-1">REMINDERS</h4>
                    Day Selected: 
                    <span class="text-primary">{{ $moment(daySelected).format('MMMM Do YY') }}</span>
                </li >
            </div>

            <div class="row mt-1">
                <div class="col-6 col-md-4 text-center  my-0">
                    <a href="#" class="card-link px-md-5" @click.stop.prevent="onPreviousDay()">previous day?</a>

                </div>
                <div class="col-6 col-md-4 text-center  my-0">
                    <a href="#" class="card-link px-md-5" @click.stop.prevent="onNextDay()">nex day?</a>

                </div>
                <div class="col-12 col-md-4 my-0">
                    <div class="form-group form-row justify-content-center">
                        <label class="col-12 col-form-label text-center text-primary py-0"> 
                            <a @click.stop.prevent="views.inputOtherDay = !views.inputOtherDay" href="#"> other day?</a> 
                        </label>
                        <transition name="bounce">
                            <div v-if="views.inputOtherDay" class="col-10 px-0 mb-1">
                                <input @change="onOtherDay()" v-model="selectOtherDay" type="date" name="calendar" class="form-control text-center px-2">
                            </div>
                        </transition>
                    </div>
                </div>
            </div>

            <transition name="bounce">
                <alert-fail :state="views.alertFail"></alert-fail>
            </transition>

            <transition name="bounce">
                <alert-uptodate :state="views.upToDate">
                    <h5 class="text-center">
                         Great! <br/>
                         You are up to date with all your reminders.
                    </h5>
                </alert-uptodate>
            </transition>

            <transition name="fade">
                <span v-if="views.content">

                    <consult-reminders
                        v-if="reminders.consult.length > 0"
                        :records="reminders.consult"
                    ></consult-reminders>

                    <custom-reminders
                        v-if="reminders.custom.length > 0"
                        :records="reminders.custom"
                    ></custom-reminders>
                    
                </span>
            </transition>

             <div class="row">
                 <div class="col-12 text-center text-muted mb-1">
                    Day Selected: 
                    <span class="text-primary">{{ $moment(daySelected).format('MMMM Do YY') }}</span>
                </div>
                <div class="col-6 col-md-4 text-center  my-0">
                    <a href="#" class="card-link px-md-5" @click.stop.prevent="onPreviousDay()">previous day?</a>

                </div>
                <div class="col-6 col-md-4 text-center  my-0">
                    <a href="#" class="card-link px-md-5" @click.stop.prevent="onNextDay()">nex day?</a>

                </div>
                <div class="col-12 col-md-4  my-0">
                    <div class="form-group form-row justify-content-center">
                        <label class="col-12 col-form-label text-center text-primary pt-0"> 
                            <a @click.stop.prevent="views.inputOtherDayBot = !views.inputOtherDayBot" href="#"> other day?</a> 
                        </label>
                        <transition name="bounce">
                            <div v-if="views.inputOtherDayBot" class="col-10 px-0 mb-1">
                                <input @change="onOtherDay()" v-model="selectOtherDay" type="date" name="calendar" class="form-control text-center px-2">
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    </div>
</template>


<script>

const moment = require('moment');
import AlertIconFail from '../alert/icon/fail.vue';
import AlertIconSuccess from '../alert/icon/success.vue';
import CustomReminders from './CustomReminders.vue';
import ConsultReminders from './ConsultReminders.vue';

export default {

    components:{
        'alert-fail': AlertIconFail,
        'alert-uptodate': AlertIconSuccess,
        'custom-reminders': CustomReminders,
        'consult-reminders': ConsultReminders
    },

    data: function(){
        return {
            timeNow: '',
            todaysDate: moment().format('MMMM Do YY'),
            reminders:{
                custom: [],
                consult: [],
            },
            routes:{
                consult:'/api/reminder-consultations',
                custom: '/api/reminder-customs'
            },
            views:{
                main: false,
                content: true,
                upToDate: false,
                alertFail: false,
                inputOtherDay: false,
                inputOtherDayBot: false,
            },
            selectOtherDay: '',
            daySelected: moment().format('YYYY-MM-DD')
        }
    },


    methods:{
        getConsult: function(daySelected){
            const vi = this;
            axios.get(vi.routes.consult + '/' + daySelected)
                .then(function(response){
                    const consult = response.data[0].reminders;
                    const clients = response.data[1].clients;

                    if(consult.length > 0 && clients.length > 0){
                        vi.mergeCollection(consult,clients);
                    }else{
                        vi.reminders.consult = [];
                    }
                    vi.verifyUpToDate();
                })
                .catch(function(error){
                    console.log('ReminderWidget.getConsult() Error: ' + error);
                    vi.views.alertFail = true;
                    vi.views.content = false;   
                });
        },
        getCustom: function(daySelected){
            const vi = this;
            axios.get(vi.routes.custom + '/' + daySelected)
                .then(function(response){
                    vi.reminders.custom = [];
                    vi.reminders.custom = response.data[0].reminders;
                    vi.verifyUpToDate();
                })
                .catch(function(error){
                    console.log('ReminderWidget.getConsult() Error: ' + error);
                    vi.views.alertFail = true;
                    vi.views.content = false;
                });
        },
        getReminders: function(){
            this.getCustom(this.daySelected);
            this.getConsult(this.daySelected);
        },
        mergeCollection: function(consults , clients){
            const vi = this;
            vi.reminders.consult = [];
            for(let consultIndex in consults){
                let wrapperObj = {};
                wrapperObj.consults = consults[consultIndex];
                
                for(let clientIndex in clients){
                    if(clients[clientIndex].id == consults[consultIndex].client_id){
                        wrapperObj.client = clients[clientIndex];
                    }
                }
                vi.reminders.consult.push(wrapperObj);		
            }
        },
        verifyUpToDate: function(){
            if(this.reminders.consult.length == 0 && this.reminders.custom.length == 0){
                this.views.upToDate = true;
            }else{
                this.views.upToDate = false;
            }
        },
        onCalendarDay: function(){

        },
        onPreviousDay: function(){
            const previousDay = moment(this.daySelected, 'YYYY-MM-DD').subtract(1 , 'days').format('YYYY-MM-DD');
            this.daySelected = '';
            this.daySelected = previousDay;

            this.getCustom(previousDay);
            this.getConsult(previousDay);
        },
        onNextDay: function(){
            const nextDay = moment(this.daySelected, 'YYYY-MM-DD').add(1 , 'days').format('YYYY-MM-DD');
            this.daySelected = '';
            this.daySelected = nextDay;

            this.getCustom(nextDay);
            this.getConsult(nextDay);
        },
        onOtherDay: function(){
            console.log(this.selectOtherDay);
            if(this.selectOtherDay.length >= 10){
                this.daySelected = '';
                this.daySelected = this.selectOtherDay;

                this.getCustom(this.selectOtherDay);
                this.getConsult(this.selectOtherDay);

            }  
        },
        reactiveTime: function(){
            const vi = this;
            setTimeout( function(){
                vi.timeNow = moment().format('h:mm:ss a');
                vi.reactiveTime();
            }, 1000 );
        },
        broadCastOnAsideNav: function(){
            Event.fire('onAsideNav', {submenu: {dashboard: true}});

        },
    },

    created:function(){
        this.getReminders();
    },
    mounted: function(){
        const vi = this;
        vi.reactiveTime();
        setTimeout( function(){
            vi.views.main = true;
        }, 1500);
        this.broadCastOnAsideNav();

       
    }
}
</script>


<style scoped>
    .dropdown-toggle::after {
        display:none
    }
    
</style>