
<template>
  
</template>


<script>

export default {
    data(){
        return{
            registry:[
                //After User logs back into app and all client forms are successfylly submitted close lockscreen
                    { from: 'OnFormStatusSubmitComplete', to: 'OnLockScreenModalOff'},
                //After User logs back into app and all client forms are successfylly submitted close lockscreen

                // If form status has no evaluation then close lockscreen.
                    { from: 'OnNoEvaluationFormStatus', to: 'OnLockScreenModalOff'},
                // If form status is evaluation fails then close lockscreen.

                // On LockScreenModal submit client forms to check for incomplete fields and validation errors.
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitCredentialsForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitMedicalForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitStressLevelForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitSkinProductsForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitMedicationsForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitAllergiesForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitIllnessesForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitSurgeriesForm'},
                    { from: 'OnSubmitLockScreenModal', to: 'OnSubmitTermsConditions'},
                // On LockScreenModal submit client forms to check for incomplete fields and validation errors.

                // If client-forms are incomplete or have missing requirement show them on LockScreenMoal
                    { from: 'OnSubmitIncompleteCredentialsForm', to: 'OnLockScreenScrollTopModal0' },
                    { from: 'OnSubmitIncompleteMedicalForm', to: 'OnLockScreenScrollTopModal1' },
                    { from: 'OnSubmitIncompleteStressLevelForm', to: 'OnLockScreenScrollTopModal1' },
                    { from: 'OnSubmitIncompleteSkinProductsForm', to: 'OnLockScreenScrollTopModal1' },
                    { from: 'OnSubmitIncompleteMedicationsForm', to: 'OnLockScreenScrollTopModal1' },
                    { from: 'OnSubmitIncompleteAllergiesForm', to: 'OnLockScreenScrollTopModal1' },
                    { from: 'OnSubmitIncompleteIllnessesForm', to: 'OnLockScreenScrollTopModal1' },
                    { from: 'OnSubmitIncompleteSurgeriesForm', to: 'OnLockScreenScrollTopModal1' },
                // If client-forms are incomplete or have missing requirement show them on LockScreenMoal

                // Validate each client-form and update the FormSatusComp: with validation did pass.
                    { from: 'OnValidationPassCredentialsForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassMedicalForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassStressLevelForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassSkinProductsForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassMedicationsForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassAllergiesForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassIllnessesForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassSurgeriesForm', to: 'OnFormStatusUpdateValidationPass' },
                    { from: 'OnValidationPassTermsConditions', to: 'OnFormStatusUpdateValidationPass' },
                // Validate each client-form and update the FormSatusComp: with validation did pass.

                // After validation passes do not submit form yer but display success submition to client.
                    { from: 'OnFormStatusValidationPass', to: 'OnLockScreenSuccess'},
                // After validation passes do not submit form yer but display success submition to client.

                // After users logs back in to the application evaluate form if it needs to be submitted or 
                // just unlock the application.
                    { from: 'OnQuickLoginSuccess', to: 'OnEvaluateFormStatus'},
                // after quick login. Options: submit form and unlock screen of just unlock screen

                // After users logs back in to the application and form staus is evaluated submit the actual 
                // data provided by the client forms.
                    { from: 'OnEveluatedFormStatusComplete', to: 'OnStoreCredentialsForm'},
                    // This is just part of the event chaing for submiting the actual data for a new client.
                    { from: 'OnSubmitSuccessCredentialsForm', to: 'OnStoreMedicalForm'},
                    { from: 'OnSubmitSuccessCredentialsForm', to: 'OnStoreTermsConditions'},
                    { from: 'OnSubmitSuccessMedicalForm', to: 'OnStoreStressLevelForm'},
                    { from: 'OnSubmitSuccessMedicalForm', to: 'OnStoreSkinProductsForm'},
                    { from: 'OnSubmitSuccessMedicalForm', to: 'OnStoreMedicationsForm'},
                    { from: 'OnSubmitSuccessMedicalForm', to: 'OnStoreAllergiesForm'},
                    { from: 'OnSubmitSuccessMedicalForm', to: 'OnStoreIllnessesForm'},
                    { from: 'OnSubmitSuccessMedicalForm', to: 'OnStoreSurgeriesForm'},                    
                // After users logs back in to the application Submit the actual data provided by the client.

                // If any of the client forms encounter a critical error the lock screen component will default.
                    { from: 'OnSubmitErrorCredentialsForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorMedicalForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorStressLevelForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorSkinProductsForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorMedicationsForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorAllergiesForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorIllnessesForm', to: 'OnLockScreenError' },
                    { from: 'OnSubmitErrorSurgeriesForm', to: 'OnLockScreenError' },
                // If any of the client forms encounter a critical error the lock screen component will default.
            ]
        }
    },

    methods:{
        loadEventsRegister(){
            const vi = this;
            for(let index in vi.registry){
                Event.listen(vi.registry[index].from, function(message){
                    Event.fire(vi.registry[index].to, message);
                });
            }
        }
    },

    mounted(){
        this.loadEventsRegister();
    }
}
</script>
