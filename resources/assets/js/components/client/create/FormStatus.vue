<template>
  
</template>

<script>
export default {
    data: function(){
        return{
            forms:{
                credentials: false,
                medical: false,
                stress_level: false,
                skin_products: false,
                medications: false,
                allergies: false,
                illnesses: false,
                surgeries: false,
                terms: false,
            },
            success:{
                credentials: false,
                medical: false,
                stress_level: false,
                skin_products: false,
                medications: false,
                allergies: false,
                illnesses: false,
                surgeries: false,
                terms: false,
            }
        }
    },
    
    methods:{
        verifyStatus: function(data){
            let status = true;

            for(let form in data){
                if(data[form] == false){
                    
                    status = false;
                }
            }
            return status;
        },
        listenOnUpdateValidationPass: function(){
            const vi = this;
            Event.listen('OnFormStatusUpdateValidationPass', function(args){
                vi.forms[args.form] = args.status;
                vi.broadCastValidationPass();
            });
        },
        listenOnUpdateSuccessStatus: function(){
            const vi = this;
            Event.listen('OnSubmitSuccessCredentialsForm', function(){
                vi.success.credentials = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessMedicalForm', function(){
                vi.success.medical = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessAllergiesForm', function(){
                vi.success.allergies = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessIllnessesForm', function(){
                vi.success.illnesses = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessMedicationsForm', function(){
                vi.success.medications = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessSkinProductsForm', function(){
                vi.success.skin_products = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessStressLevelForm', function(){
                vi.success.stress_level = true;
                vi.verifyAllFormsSubmitComplete();
            });
            Event.listen('OnSubmitSuccessSurgeriesForm', function(){
                vi.success.surgeries = true;
                vi.verifyAllFormsSubmitComplete();
            });
             Event.listen('OnSubmitSuccessTermsConditions', function(){
                vi.success.terms = true;
                vi.verifyAllFormsSubmitComplete();
            });

        },
        broadCastValidationPass: function(){
            if(this.verifyStatus(this.forms)){
                Event.fire('OnFormStatusValidationPass');
            }
        },
        verifyAllFormsSubmitComplete: function(){
            if(this.verifyStatus(this.success)){
                Event.fire('OnFormStatusSubmitComplete');
            }
        },
        listenOnEvaluateFormStatus: function(){
            const vi = this;
            Event.listen('OnEvaluateFormStatus', function(){
                if(vi.verifyStatus(vi.forms)){
                    Event.fire('OnEveluatedFormStatusComplete');
                }else{
                    Event.fire('OnNoEvaluationFormStatus');
                }
            });
        }
    },

    mounted: function(){
        this.listenOnUpdateValidationPass();
        this.listenOnUpdateSuccessStatus();
        this.listenOnEvaluateFormStatus();
    }
}
</script>
