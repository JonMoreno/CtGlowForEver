
<template>
    <div>
    <transition name="fade">
        <div v-if="views.main" class="card card-body my-3 my-md-5 border-light-secondary">
            <div class="row d-flex align-items-center">

                <div class="col-12 col-md-6 col-lg-4 text-center">
                        <h4 class="mb-2 ls-05">
                            <span class="gfe-text-lred">{{ user }}</span><br/>
                            <span class="text-secondary"> Welcome back!</span>
                        </h4>
                        <h6 class="mb-1 text-muted"> 
                                This is today's quote 
                                <i class="fa fa-angle-double-right gfe-text-primary" aria-hidden="true"></i>
                            <br/>
                            <span class="pl-2">
                                Let's get some inspiration! 
                                <i class="fa fa-angle-double-right gfe-text-primary" aria-hidden="true"></i>
                            </span>
                        </h6>
                </div>

                <div class="col-12 col-md-6 col-lg-5">
                    <div class="">
                        <hr class="no-border my-0"/>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row"><div class="col gfe-text-primary font-weight-bold">Quote</div></div>
                                <div class="row"><div class="offset-1 col-10">{{ randomQuote.text }}</div></div>
                            </li>
                            <li class="list-group-item">
                                <div class="gfe-text-primary font-weight-bold">
                                    Author<br/>
                                    <span class="text-dark pl-3 font-weight-normal">{{randomQuote.author }}</span>
                                </div>
                                
                            </li>
                        </ul>
                    
                    </div>
                </div>
            <!-- Desktop Friendly -->
                <div class="col-12 col-md-12 col-lg-3 px-0">
                    <div class=" text-center mt-md-4">
                        <a 
                            href="#" 
                            @click.stop.prevent="getInspiration()"
                            class="btn btn-primary gfe-bg-primary text-white my-2">
                            
                            <span v-if="!inspBtn" class="ls-05"> not inspired yet? </span>
                            <span v-else class="font-weight-bold ls-2"> getting <br/> inspiration<i class="fa fa-spinner fa-spin fa-spin fa-lg"></i></span>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    </div>
</template>


<script>

export default {

    props:{
        user: [String,Object],
        required: false
    },

    data: function(){
        return {
            route: 'https://api.forismatic.com/api/1.0',
            method: 'method=getQuote',
            format: 'format=json',
            key: 'key=457653',
            lang: 'lang=en',  
            randomQuote: {
                text: '',
                author: ''
            },
            views: {
                main: false
            },
            inspBtn: false,
        }
    },

    methods:{
        getInspiration: function(){
            this.inspBtn = true;
            this.getRandomQuote(true);
        },
        getRandomQuote: function(getInspiration = false){
            const vi = this;  
            axios.get('/api/external-api/quote')
                .then( function(response){
                    console.log(response.data);
                    vi.randomQuote.text = response.data.quoteText;
                    vi.randomQuote.author = response.data.quoteAuthor;

                    if(getInspiration){
                        setTimeout( function() { 
                            vi.inspBtn = false;
                        },800);
                    }
                })
                .catch( function(error){
                    console.log(error);
                    console.log(error.response);
                    console.log('QuoteWidget.getRandomQuote(); Error' + error);
                });
        },
    },

    created: function(){
        //this.getRandomQuote();
    },
    mounted: function(){
        const vi = this;
        vi.getRandomQuote();
        setTimeout( function(){
            vi.views.main = true;
        }, 1000);
    }
}
</script>

