//TEMPLATE
<template>
    <div class="py-3 px-2">
        <h5 class="font-weight-bold">Products Sold</h5>
        <div class="list-group">
            <a v-if="info.length == 0"
                class="list-group-item list-group-item-action text-center px-2">
                <p class="text-muted font-weight-bold">
                    <i class="fa fa-info-circle fa-lg text-primary" aria-hidden="true"></i>Products Were Not Purchased
                </p>
            </a>
            <a v-else v-for="(purchase, index) in info" :key="purchase.id"
                class="list-group-item list-group-item-action flex-column align-items-start px-2">

                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="text-capitalize">
                        <span class="font-weight-bold">#{{Number(index)+ 1}}</span> 
                        {{ purchase.product.name }}
                    </div>
                    <div>
                        Sold Price:
                        <span class="badge badge-success py-2">
                            ${{soldAtPrice(index, purchase.product_id)}}
                        </span>
                    </div>
                </div>

                <p v-if="hasDiscount(purchase.product_id)" class="bg-light-danger rounded my-2 py-1 pl-1">
                    <strong>Discount Applied:</strong> <br/>

                    <span class="pl-2">{{ discountName(purchase.product_id) }}</span> <br/>

                    <span class="pl-2">Original Price:<del>{{ (purchase.sold_price) }}</del>  

                        <i class="fa fa-arrow-right"></i>

                        <strong class="text-danger">
                            {{discountValue(purchase.product_id) }}
                        </strong>

                    </span> 
                </p>

            </a>
        </div>
    </div>
</template>

//SCRIPT
<script>
export default {
    props: {
        info:{
            type: Array,
            required: false
        },
        discounts: {
            type: Array,
            required: false
        }
    },

    methods: {
    //mathematical operations.
        subtractMonetary: function(maxVal , minVal) {
           let total =  Number(maxVal) - Number(minVal);
           return total.toFixed(2);
        },
        subtractPercentage: function(orginal_price , discount_value) {
            let discount_amount = (discount_value / 100) * orginal_price;
            let discounted = Number(orginal_price ) - Number(discount_amount);
            return discounted.toFixed(2);
        },

    //discount applicable operations.
        discountName: function(ref) {
            let size = this.discounts.length;
            let discounts = this.discounts;

            for(let i = 0; i < size; i++){
                if(discounts[i].service == 'product' && discounts[i].service_id == ref){
                    return discounts[i].discount.name;
                }
            }
        },
        discountValue: function(ref) {
            let size = this.discounts.length;
            let discounts = this.discounts;

            for(let i = 0; i < size; i++){
                if(discounts[i].service == 'product' && discounts[i].service_id == ref){

                    if(discounts[i].discount_type == 'monetary'){
                        return "-$" + discounts[i].discount_value + 'OFF';
                    }else {
                        return "-" + discounts[i].discount_value + '%OFF';
                    }
                }
            }

        },
        hasDiscount: function(ref) {
            let size = this.discounts.length;
            let discounts = this.discounts;
            
            for(let i = 0; i < size; i++){
                if(discounts[i].service == 'product' && discounts[i].service_id == ref){
                    return true;
                }
            }

        },
        soldAtPrice: function(index, ref) {
            let vi = this;
            let size = this.discounts.length;
            let discounts = this.discounts;

            let found;
            if(size > 0) {
                for(let i = 0; i < size; i++){
                    if(discounts[i].service == 'product' && discounts[i].service_id == ref){
                        if(discounts[i].discount_type == 'monetary'){
                            found = true;
                            return vi.subtractMonetary(discounts[i].service_original_price , discounts[i].discount_value);

                        }else if(discounts[i].discount_type == 'percentage'){
                            let found = true;
                            return vi.subtractPercentage(discounts[i].service_original_price , discounts[i].discount_value);
                            
                        }
                    }else if(!found && i == (Number(size) - 1)){
                        return vi.info[index].sold_price;

                    }
                }
            }else{
                return vi.info[index].sold_price;
            }
            
        },
    }
  
}
</script>

