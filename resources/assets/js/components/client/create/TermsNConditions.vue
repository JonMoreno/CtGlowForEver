

<template>
    <div>
  <!-- FORM DIVIDER -->
        <br/><br/><br/>
        <div class="divider mb-0 pt-1"></div>
        <p class="text-muted text-center ls-1 font-weight-bold"> 
            <span v-if="views.lang.english"> thank you for your patience </span>
            <span v-else>muchas gracias por su paciencia </span>
        </p>
    <!-- FORM TERMS AND CONDITIONS -->
        <p class="text-muted mb-2">
            <span v-if="views.lang.english"> {{ description.english }} </span>
            <span v-else> {{ description.spanish }} </span>
        </p>
        <div class="row mb-4">
            <div class="form-group col-12 text-center">
                <div class="form-check">
                    <input @change="validateTerms()" name="terms" v-model="terms" class="form-check-input big-checkbox" type="checkbox" required>
                    <label class="form-check-label-lg f-100 ml-2 mt-1 text-uppercase">
                        <span v-if="views.lang.english"> Agree to terms and conditions </span>
                        <span v-else> Acepta los términos y condiciones </span>
                    </label>
                </div>
            </div>
            <div v-if="validate.termsFail" class="col-12 my-0 text-danger text-center">
                <span v-if="views.lang.english"> Your agreement is required. </span>
                <span v-else> Su acuerdo es requerido.</span>
            </div>
        </div>

        <signature-pad></signature-pad>

        <!-- <button @click="testTerms()" class="btn btn-info">
            Testing
        </button> -->
    </div>
</template>


<script>

import SignaturePad from '../../main/SignaturePad.vue';

export default {
    
    components:{
        'signature-pad': SignaturePad
    },

    data: function(){
        return{
            signature: null,
            clientRef: false,
            route: '/api/terms-and-conditions',
            terms: false,
            description:{
                english: 'I release them from any liability that arises because of the nature of the skin and unrelated to the treatment. I certify that I have read and understood my explanation of the treatment and the responsibility that I have for the success of this and the precautions that I must have, my signature certifies my approval to do it.',
                spanish: 'Los libero de cualquier responsabilidad que surja debido a la naturaleza de la piel y no relacionada con el tratamiento. Certifico que he leído y entendido mi explicación del tratamiento y la responsabilidad que tengo para el éxito de esta y las precauciones que debo tener, mi firma certifica mi aprobación para hacerlo.',
            },
            views:{
                lang:{
                    english: true,
                    spanish: false
                }
            },
            validate: {
                termsFail: false,
            }
        }
    },
    methods:{
        storeTermsConditions: function(data){
            const vi = this;
            axios.post(vi.route, data)
                .then( function(response){
                    Event.fire('OnSubmitSuccessTermsConditions');
                })
                .catch( function(error){
                    console.log('TermsAndConditions.storeTermsConditions(); Error:' + error);
                });
        },
        toggleLanguage: function(pick){
            for(let lang in this.views.lang){
                if(lang == pick){
                    this.views.lang[pick] = true;
                }else{
                    this.views.lang[lang] = false;
                }
            }
        },
        prepFormData: function(){
            const vi = this;
            let formData = {
                'client_id': vi.clientRef,
                'name': 'New Client Form',
                'description': vi.views.lang.spanish ? vi.description.spanish : vi.description.english,
                'signature': vi.signature, 
                'signature_image': 'Signature' + (Math.random().toString(36).substring(7)) + '.jpeg',
            }
            return formData;
        },
        validateTermsConditions: function(){
            if(!this.validateTerms() || this.signature == null){
                return false;
            }
            this.validate.terms = true;
            return true;
        },
        validateTerms: function(){
            if(this.terms != true){
                this.validate.termsFail = true;
                return false;
            }
            this.validate.termsFail = false;
            return true;
        },
        broadCastOnValidationPass: function(){
            Event.fire('OnValidationPassTermsConditions', {form: 'terms', status: true});
        },
        listenOnStoreForm: function(){
            const vi = this;
             Event.listen('OnStoreTermsConditions', function(response){
                vi.clientRef = response;
                if(vi.clientRef !== false && vi.clientRef != null){
                    if(vi.validateTermsConditions()){
                        vi.storeTermsConditions(vi.prepFormData());
                    }
                }
            });
        },
        listenOnSubmit: function(){
            const vi = this;
            Event.listen('OnSubmitTermsConditions', function(){
                vi.broadCastRetrieveSignature();
                if(vi.validateTermsConditions()){
                    vi.broadCastOnValidationPass();
                }
            });
        },
        broadCastRetrieveSignature: function(){
            Event.fire('OnRetrieveSignaturePad');
        },
        listenOnSignaturePadSigned: function(){
            const vi = this;
            Event.listen('OnSignaturePadSigned', function(signature){
                vi.signature = signature;
            });
        },
        listenOnLanguageChange: function(){
            const vi = this;
            Event.listen('OnLanguageChange', function(selection){
                vi.toggleLanguage(selection);
            }); 
        }
    },

    mounted: function(){
        this.listenOnSubmit();
        this.listenOnStoreForm();
        this.listenOnLanguageChange();
        this.listenOnSignaturePadSigned();
    }
}
</script>


<style scoped>
    .big-checkbox {
        width: 25px; height: 25px;
    }  
    .f-100{
        font-size:  100% !important;
    } 
</style>



