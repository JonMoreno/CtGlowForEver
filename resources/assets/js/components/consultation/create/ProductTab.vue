<template>
    <div>
        <!-- row -->
            <div class="row no-gutters border-light-secondary bg-light px-2 py-3 mb-3 rounded">
            <!-- col -->
                <div class="col-3 col-sm-12 col-md-3 d-flex justify-content-center">
                    <div class="align-self-center lead h5 text-center">
                        Purchase Products?
                    </div>
                </div>
            <!-- col -->
                <div class="col-9 col-sm-12 col-md-9 px-2">

                    <slot></slot>                  
                    
                </div>
            <!-- ../col -->
            </div>
        <!-- ../row -->
    </div>
</template>

<style scoped>
.gfe-checkbox {
    width: 25px !important; 
    height: 30px !important;
}
</style>


