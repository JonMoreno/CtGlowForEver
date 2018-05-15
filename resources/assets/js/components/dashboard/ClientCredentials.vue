<template>
    <div class="btn-group dropright">
        <a class="btn btn-link gfe-text-primary dropdown-toggle px-0 py-0 my-0" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mb-1">
                <span v-html="genderIcon"></span>
                {{ credentials.first_name + ' ' + credentials.last_name }}
            </span>
        </a>
        <div class="mt-4 dropdown-menu mw-300 ">
            <div class="card px-2 py-3 bg-white">
                <img class="card-img-top" :src="profilePic" alt="Card image cap">

                <div class="card-body px-1 py-0 text-center ls-05 gfe-text-lred">
                    <p class="card-text">
                        {{ credentials.first_name + ' ' + credentials.last_name }}
                        <span v-if="credentials.dob != null" class="badge badge-light text-primary border-light-secondary mr-2">{{ age }}y/o</span>

                    </p>
                </div>

                <div class="card-body px-1 py-1">
                    <div class="font-weight-bold">Phone: </div>

                    <div class="text-center mb-2">
                        <a :href="mobile" class="card-link">{{ mobile }}</a>
                    </div>

                    <div class="font-weight-bold">Address:</div>

                    <div class="text-center"> 
                        {{ credentials.apt_floor != null ? credentials.apt_floor : '' }} <br/>
                        {{ credentials.street != null ? credentials.street : '' }} <br/>
                        {{ credentials.city != null ? credentials.city : ''}} {{ credentials.state != null ? credentials.state : '' }} <br/>
                        {{ credentials.zip != null ? credentials.zip : '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

import Moment from 'moment';

export default {
    props:{
        credentials:{
            type: [Object,String],
            required: true
        }
    },

    computed:{
        genderIcon: function(){
            if(this.credentials.gender == 'male'){
                return '<i class="fa fa-male" aria-hidden="true"></i>';
            }else{
                return '<i class="fa fa-female" aria-hidden="true"></i>';
            }
        },
        mobile: function(){
            if(this.credentials.cellular != null){
                return this.credentials.cellular;
            }
        },
        profilePic: function(){
            if(this.credentials.image != null){
                return this.credentials.image;
            }
        },
        age: function(){
			const formatDOB = Moment(this.credentials.dob, 'MM-DD-YYYY');
			return Moment().diff(formatDOB, "years");
		},
    }
}
</script>


<style scoped>
    .dropdown-toggle::after {
        display:none !important;
    }
    .mw-300{
       min-width: 300px !important;
    }
    
</style>