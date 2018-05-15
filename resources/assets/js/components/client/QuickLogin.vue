<template>
    <div>
        <form v-if="views.form">
            <div class="form-row">
                <div class="col-6 pl-3">
                    <input 
                        type="text"
                        v-model="user.email"
                        placeholder="Email" 
                        class="form-control"> 
                </div>
                <div class="col-5">
                    <input 
                        type="password"
                        v-model="user.password"
                        class="form-control" 
                        placeholder="Password">
                </div>
                <div class="col-1">
                    <button 
                        type="button" 
                        class="btn btn-link pb-0 pt-1 px-0"
                        @click="unlockScreen()">
                        <i class="fa fa-unlock-alt fa-2x" aria-hidden="true"></i>
                    </button>
                </div>
                <transition name="bounce">
                    <div v-if="views.loginFail" class="col-11 pl-3">
                        <div class="alert alert-danger mt-2 mb-0 text-center py-1 ls-05" role="alert">
                            These credentials do not match our records.
                        </div>
                    </div>
                </transition>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props:{
        email:{
            default: '',
            type: String,
            required: false
        },
        password:{
            default: '',
            type: String,
            required: false
        }
    },

    data() {
        return {
            user:{
                email: '',
                password: ''
            },
            views:{
                form: true,
                loginFail: false
            },
            route: '/api/lock-screen'
        }
    },

    methods: {
        unlockScreen(){
            const vi = this;
            axios.post( vi.route ,  {'email': vi.user.email, 'password': vi.user.password } )
                .then( function(response){
                    Event.fire('OnQuickLoginSuccess');
                })
                .catch( function(error){
                    vi.views.loginFail = true;
                })
        }
    },

    mounted() {
        this.email = this.user.email;
        this.password = this.user.password;
    }
}
</script>

