
<template>
<!-- modal -->
    <div :id="modalId" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <!-- model-dialog -->
        <div class="modal-dialog mx-auto">
            <div v-show="header" class="modal-content mx-auto rd-8 my-4">
                <div class="modal-body px-5 py-2">
                    <slot name="header"></slot>
                </div>
            </div>

            <transition name="fade">
                <div v-if="views.alertFail" id="alertFail" class="modal-content mx-auto radius-apply mb-5">
                    <div class="modal-body px-5 py-5 d-flex align-items-center justify-content-center">
                        <alert-fail :state="views.alertFail">
                            <div class="text-center h5 mt-2">
                                SOMETHING WENT TERRIBLY WRONG!<br/>
                                This is embarassing. Please contact your developer as soon as possible<br/>
                                Error: LockScren.OnLockScreenScreenError();
                            </div>
                        </alert-fail>
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div v-if="views.alertSuccess" id="alertSuccess" class="modal-content mx-auto radius-apply mb-5">
                    <div class="modal-body px-5 py-5 d-flex align-items-center justify-content-center">
                        <alert-success :state="views.alertSuccess">
                            <div v-if="views.lang.english" class="text-center h5 mt-2">
                                YOU HAVE COMPLETED THIS FORM<br/>
                                Please, take this up to your consultation specialist. <br/>
                                Thank You!
                            </div>
                            <div v-else class="text-center h5 mt-2">
                                USTED HA COMPLETADO ESTE FORMULARIO. <br/>
                                Por favor, lleve esto a su especialista en consultas.<br/>
                                ¡Gracias! 
                            </div>
                        </alert-success>
                    </div>
                </div>
            </transition>

            <div v-show="views.main">
                <div v-show="preContent" class="modal-content mx-auto radius-apply mb-5">
                    <div class="modal-body px-5 text-muted" id="modalBody0">
                        <slot name="preContent">
                        </slot>
                    </div>
                </div>

                <div v-show="content" class="modal-content mx-auto radius-apply mb-5">
                    <div class="modal-body px-5 text-muted" id="modalBody1">
                        <slot name="content">
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <div class="d-block w-100 text-center">
                                <button 
                                    type="button" 
                                    @click="broadCastOnSubmit()"
                                    :class="{disabled : views.submitBtn}"
                                    class="btn btn-outline-primary btn-lg ls-05">
                                    <i v-if="views.submitBtn" class="fa fa-spinner fa-spin"></i>
                                    <span v-if="views.lang.english">Save Form </span>
                                    <span v-else>Guardar formulario </span>
                                </button>
                            </div>
                        </slot>
                    </div>
                </div><!-- ../modal-content -->
            </div>
        </div><!-- ../modal-dialog -->
    </div><!-- ../modal -->
</template>


<script>
import AlertFail from '../../alert/icon/fail.vue';
import AlertSuccess from '../../alert/icon/success.vue';

export default {

    components:{
        'alert-fail': AlertFail,
        'alert-success': AlertSuccess
    },

    props: {
        onListen:{
            type: String,
            required: false,
            default: 'OnLockScreenModal'
        },
        modalId:{
            type: String,
            required: false,
            default: 'lockScreenModal'
        },
        header:{
            type: Boolean,
            default: false,
            required: false
        },
        preContent:{
            type: Boolean,
            default: false,
            required: false
        },
        content:{
            type: Boolean,
            default: 'false',
            required: false
        },
        route:{
            type: String,
            required: false
        },
        autoload:{
            type: Boolean,
            required: false,
            default: false
        }
        
    },

    data: function(){
        return {
            position:{
                priority:{
                    modalBody0: false
                }
            },
            views:{
                main: true,
                alertFail: false,
                submitBtn: false,
                alertSuccess: false,
                lang:{
                    english: true,
                    spanish: false
                }
            }
        }
    },

    methods:{
        lockScreenOn: function(path){
            const vi = this;
            axios.get(path)
                .then( function(response){})
                .catch( function(error){
                    console.log('LockScreen.lockScreenOn(); Error:' + error);
                    $("#" + vi.modalId).modal('hide');
                });
        },
        listenOnLockScreenModalOff: function(){
            const vi = this;
            Event.listen('OnLockScreenModalOff', function(){
                setTimeout( function(){
                    $("#" + vi.modalId).modal('hide');
                    window.location.href = '/dashboard/';
                }, 500);
            });
        },
        listenOnLockScreenModal: function(){
            const vi = this;
            const id = "#" + this.modalId;
            Event.listen(vi.onListen, function(){
                $(id).modal({backdrop: 'static', keyboard: false});
                vi.lockScreenOn(vi.route);
            });
        },
        listenOnLockScreenError: function(){
            const vi = this;
            Event.listen('OnLockScreenScreenError', function(){
                vi.views.alertFail = true;
                vi.views.main = false;
            });
        },
        listenOnLockScreenScrollTop: function(){
            const vi = this;
            // MODAL 0 SECITON
            Event.listen('OnLockScreenScrollTopModal0', function(){
                vi.views.submitBtn = false;
                vi.position.priority.modalBody0 = true;
                const modalBody0 = document.getElementById('modalBody0');
                modalBody0.scrollIntoView( {behavior: 'smooth', block: 'start'} );
            });
            // MODAL 1 SECITON
            Event.listen('OnLockScreenScrollTopModal1', function(){
                vi.views.submitBtn = false;
                if(vi.position.priority.modalBody0){
                    const modalBody0 = document.getElementById('modalBody0');
                    modalBody0.scrollIntoView( {behavior: 'smooth', block: 'start'} );
                    setTimeout( function(){
                        vi.position.priority.modalBody0 = false;
                    },1000);
                }else{
                    const modalBody1 = document.getElementById('modalBody1');
                    modalBody1.scrollIntoView( {behavior: 'smooth', block: 'start'} );
                }
            });
        },
        broadCastOnSubmit: function(){
            const vi = this;
            vi.views.submitBtn = true;
            Event.fire('OnSubmitLockScreenModal');
            setTimeout( function(){
                vi.views.submitBtn = false;
            }, 5000);
        },
        listenOnLockScreenSuccess: function(){
            const vi = this;
            Event.listen('OnLockScreenSuccess', function(){
                vi.views.main = false;
                vi.views.alertSuccess = true;
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
        listenOnLanguageChange: function(){
            const vi = this;
            Event.listen('OnLanguageChange', function(selection){
                vi.toggleLanguage(selection);
            }); 
        },
        openModal: function(){
            const vi = this;
            if(vi.autoload){
                $('#' + vi.modalId).modal({backdrop: 'static', keyboard: false});
            }
        }   
    }, 

    mounted: function(){
        const vi = this;
        vi.openModal();
        vi.listenOnLockScreenModal();
        vi.listenOnLockScreenError();
        vi.listenOnLanguageChange();
        vi.listenOnLockScreenSuccess();
        vi.listenOnLockScreenModalOff();
        vi.listenOnLockScreenScrollTop();

        vi.listenOnVerify     
    }
}
</script>


<style scoped>
    .overflow{
        overflow: scroll !important;
        max-height: 800px;
    }
    .modal-dialog {
        width: 100% !important;
        height: 100% !important;
        max-width: 750px !important;
    }

    .modal-content {
        height: auto  !important;
        border-radius: 0 !important;
    }
    .radius-apply{
        border-radius: 25px !important;
    }
    .rd-8{
        border-radius: 8px !important;
    }
</style>

