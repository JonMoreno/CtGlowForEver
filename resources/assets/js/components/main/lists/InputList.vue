
<template>
    <transition-group name="list">
        <div v-for="(input,index) in list" :key="index">
            <input 
                type="text"
                :name="targetName"
                v-model="input.value" 
                @keyup="addInputRow(index)" 
                @blur="removeInputRow(index)"

                class="form-control form-control-lg">
        </div>
    </transition-group>
</template>

<script type="type/script">

window._ = require('lodash');

export default {

    props:{
        targetName:{
            type: String,
            required: true,
        },
        targetArrey:{
            type: String,
            required: true,
        }
    },

    data: function(){
        return {
            list: [
                { value: '' },
                { value: '' },
            ],
        }
    },

    methods:{

        /**
         * This method will serve as a way of appending 
         * a row when the second to last row has
         * began to be filled by the user.
         * 
         * @param int index
         */
        addInputRow: _.debounce(function(index){
            const vi = this;
            if(index == (vi.list.length  -1)){ //append input only on last item.
                vi.list.push({value: ''});
            }
            vi.broadCastOnInputList();
        }, 200),

        /**
         * This method will serve as a way of removing any 
         * row with an empty value execpt for last
         * row as it is part fo the design.
         * 
         * @param int index
         */
        removeInputRow: function(index){
            if(this.list.length > 2){ // always leave to rows as per design feature.
                if(this.list[index].value.length == 0 && index != (this.list.length -1)){
                    this.list.splice(index, 1);
                }
            }
            this.broadCastOnInputList();
        },

        /**
         * This method will take care of broadcasting 
         * object array to parent component while 
         * extracting any empty value, while 
         * leaving original array intact.
         * 
         * @param int index
         */
        broadCastOnInputList: function(){
            const vi = this;
            //Clone this.list and broadcast clone 
            // with no empty values in the array.
            let clone = vi.list.slice();

            clone.splice((vi.list.length -1), 1); // remove extra index belonging to this.list;
            for(let index in clone){
                if(clone[index].value.length == 0){
                    console.log('splicing')
                    clone.splice(index, 1);
                }
            }
            Event.fire('OnInputList', { targetArrey: vi.targetArrey , data: clone });
        },
    },
}
</script>

