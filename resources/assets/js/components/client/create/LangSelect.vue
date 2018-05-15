

<template>
    <div> 
        <p class="ls-1 mb-0 mt-1">
             <a  
                href="#"
                class="pr-1"
                :class="[language.english ? '' : 'text-muted']"
                @click.stop.prevent="toggleLanguage('english')"> 
                english
            </a>
            <a 
                href="#"
                class="pl-1"
                :class="[language.spanish ? '' : 'text-muted']"
                @click.stop.prevent="toggleLanguage('spanish')"> 
                spanish 
            </a>
        </p>
    </div>
</template>


<script>

export default {

    data: function(){
        return{
            language: {
                english: true,
                spanish: false,
            }
        }
    },

    methods:{
        toggleLanguage: function(pick){
            for(let lang in this.language){
                if(lang == pick){
                    this.language[pick] = true;
                    this.broadCastOnLanguageChange(pick);
                }else{
                    this.language[lang] = false;
                }
            }
        },
        broadCastOnLanguageChange: function(pick){
            Event.fire('OnLanguageChange', pick);
        }
    }
}
</script>

