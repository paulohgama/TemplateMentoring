<template>
    <div class="row">
        <div class="col-md-6">
            <div class="wrap-content">
                <div class="select-quantity-comp">
                    <div class="header">
                        <span class="spriting sprite-clock"></span>
                        <h6>Quantidade de créditos</h6>
                    </div>
                    <div class="body">
                        <div class="chooser">
                            <label for="minutes">Min/</label>
                            <div class="wrap-input">
                                <input type="text" :value="minutes + ' minuto(s)'" readonly id="minutes" required>
                                <div class="selector">
                                    <div class="increment" @click="increment" id="increment"></div>
                                    <div class="decrement" @click="decrement" id="decrement"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="wrap-content price">
                <div class="spriting sprite-clock-rounded"></div>
                <div class="text">
                    <h6>Valor por min/</h6>
                    <span class="price">R$ {{formatprice(price)}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="wrap-content price">
                <div class="spriting sprite-clock-rounded"></div>
                <div class="text">
                    <h6>Valor Total</h6>
                    <span class="price">R$ {{formatprice(total)}}</span>
                </div>
            </div>
        </div>
        <input type="hidden" id="totalminutes" name="totalminutes" :value="total">
    </div>
</template>

<script>
    export default {
        props: {price: Number},
        data() {
            return {
                minutes: 10,
                total: 10*this.price,
            }
        },
        methods: {
            increment(){
                this.minutes += 1;
                this.total = this.minutes * this.price;
            },
            decrement(){
                if(this.minutes > 0) {
                    this.minutes -= 1;
                    this.total = this.minutes * this.price;
                }
            },
            formatprice(value)
            {
               let retorna = parseFloat(Math.round(value * 100) / 100).toFixed(2);
               return retorna.replace(".", ",");
            },
        }
    }
</script>
