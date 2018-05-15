<template>
<!-- E-SIGNATURE CANVAS-->
    <div class="row">
    <!-- TODAY'S DATE -->
        <div class="col-12 text-center">
            <div class="form-row">
                <label class="col-form-label-sm col-6 text-right text-dark ls-05 text-primary">
                    <span v-if="views.lang.english">Today's Date:</span>
                    <span v-else> Fecha De Hoy: </span>
                </label>
                <div class="col-6">
                    <input type="text" class="form-control form-control-sm form-control-plaintext bg-white" :value="today" readonly>
                </div>
            </div>
        </div>
            <!-- VALIDATION MSG -->
        <div v-if="views.validationMsg" class="col-12">
            <div class="alert alert-danger text-center mx-4">
                <span v-if="views.lang.english">Your Signature is required. Please, sign below.</span>
                <span v-else>Su firma es requerida. Por favor, firme abajo.</span>
            </div>
        </div>
    <!-- E-SIGNATURE -->
        <div class="mx-auto">
            <canvas id="e-signature" class="border rounded" width="600" height="150">
            </canvas>
        </div>
    <!-- CLEAR SIGNATURE -->
        <div class="col-12 text-center mt-0 ">
            <button @click="signaturePad.clear()" type="button" class="btn btn-link btn-sm ls-1 py-0">
                <span v-if="views.lang.english">CLEAR SIGNATURE</span>
                <span v-else>BORRAR FIRMA</span>
            </button>
        </div>
    </div>
</template>


<script>

import Moment from 'moment';
import SignaturePad from 'signature_pad';

export default {

    data: function(){
        return {
            today: Moment().format('MM-DD-YYYY'),
            signaturePad: '',
            eSignature: '',
            canvas: '',
            views:{
                lang:{
                    spanish: false,
                    english: true,
                },
                validationMsg: false
            }
        }
    },

    methods:{
        toggleLanguage: function(pick){
            for(let lang in this.views.lang){
                if(lang == pick){
                    this.views.lang[pick] = true;
                }else{
                    this.views.lang[lang] = false;
                }
            }
        },
        retrieveSignature: function(){
            if(this.validateSignature()){
                this.prepSignature();
                this.broadCastSignaturePadSigned();
            }
        },
        prepSignature: function(){
            const signatureJPEG = this.signaturePad.toDataURL("image/jpeg");
            this.eSignature = signatureJPEG;
        },
        validateSignature: function(input){ // No _.debounce() for rapid looping.
            const vi = this;
            if(vi.signaturePad.isEmpty()){
                vi.views.validationMsg = true;
                return false;
            }else{
                vi.views.validationMsg = false;
                return true;
            }
        },
        broadCastSignaturePadSigned: function(){
            const signature = this.eSignature;
            Event.fire('OnSignaturePadSigned', signature);
        },
        listenOnRetrieveSignaturePad: function(){
            const vi = this;
            Event.listen('OnRetrieveSignaturePad', function(){
                vi.retrieveSignature();
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
        const vi = this;
        vi.listenOnLanguageChange();
        vi.listenOnRetrieveSignaturePad();
        vi.canvas = document.getElementById('e-signature');
        vi.signaturePad = new SignaturePad(vi.canvas, { backgroundColor: 'rgb(255, 255, 255)', penColor: "rgb(26, 136, 255)"});
    }
}
</script>
