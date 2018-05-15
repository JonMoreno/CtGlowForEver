//TEMPLATE
<template>
    <div class="d-flex justify-content-end text-right">

        <div v-for="(invoice, index) in info" :key="invoice.id">
            <small v-if="hasDiscount()">
                    Total Discount:<br/>
                
                    Discount: {{ discountName() }} <br/>

                    Sub Total: <del>${{ preDiscountTotal(index) }} </del> ->
                    <strong class="text-danger"> 
                        {{ discountValue() }}
                    </strong>

            </small>
            <h5 class="text-right">
                    INVOICE TOTAL: 
                <span class="gfe-text-lred font-weight-bold">
                    ${{ invoice.total_price  }}
                </span>
            </h5>
        </div>

    </div>
</template>

//SCRIPT
<script>
export default {
    props: {
        info:{
            type: [String,Array],
            required: true
        },
        discounts: {
            type: Array,
            required: false
        }
    },

    data: function() {
        return {
        }
    },

    methods: {
    ///////////////////////
        hasDiscount: function(ref) {
            let size = this.discounts.length;
            let discounts = this.discounts;
            
            for(let i = 0; i < size; i++){
                if(discounts[i].service == null && discounts[i].service_id == null){
                    return true;
                }
            }

        },
        discountName: function(ref) {
            let size = this.discounts.length;
            let discounts = this.discounts;

            for(let i = 0; i < size; i++){
                if(discounts[i].service == null && discounts[i].service_id == null){
                    return discounts[i].discount.name;
                }
            }
        },
        discountValue: function(ref) {
            let size = this.discounts.length;
            let discounts = this.discounts;

            for(let i = 0; i < size; i++){
                if(discounts[i].service == null && discounts[i].service_id == null){

                    if(discounts[i].discount_type == 'monetary'){
                        return "-$" + discounts[i].discount_value + 'OFF';
                    }else {
                        return "-" + discounts[i].discount_value + '%OFF';
                    }
                }
            }
        },
        preDiscountTotal: function(index) {
            let vi = this;
            let size = this.discounts.length;
            let discounts = this.discounts;

            for(let i = 0; i < size; i++){
                if(discounts[i].service == null && discounts[i].service_id == null){
                    return vi.subTotal(index, discounts[i].discount_type, discounts[i].discount_value);
                }
            }

        },
    //discount applicable operations.
        subTotal: function(index, discount_type, discount_value) {
            let vi = this;
            let total = this.info[index].total_price;

            if(discount_type == 'monetary'){
                return vi.reverseMonetary(total, discount_value);
            }else{
                return vi.reversePercentage(total, discount_value);

                // develop reverse engineer percentage.
            }

        },
    //mathematical operations.
        reverseMonetary: function(maxVal , minVal) {
           let total =  Number(maxVal) + Number(minVal);
           return total.toFixed(2);
        },
        reversePercentage: function(total, discount_value) {
            let decrease_percentage = 100 - Number(discount_value);
            let before_discount_total = ( total * 100) / decrease_percentage;
            return before_discount_total.toFixed(2);
        }     
    },

    created: function() {

    },

    mounted: function() {
    }
  
}
</script>

