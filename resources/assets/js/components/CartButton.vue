<template>
    <div id="cartButton" class="col-3 d-flex align-items-center">
        <a class="btn btn-success w-100 h-75" href="#"  data-toggle="modal" data-target="#cartModal">
            <div class="cart d-flex flex-row">
                <div class="d-inline-flex shopping-cart align-items-center justify-content-center">
                    <i class="fas fa-shopping-cart h-50 w-50"></i>
                </div>
                <div class="cart-info d-inline-flex p-2 justify-content-center flex-column">
                    <p class="m-0 d-flex align-items-start">{{ trans('localization.in_the_cart')}}: <strong class="ml-2">{{ totalQty() }}</strong></p>
                    <p class="m-0 d-flex align-items-start">{{ trans('localization.total')}}: <strong class="ml-2">{{ totalPrice() }} грн</strong></p>
                </div>
            </div>
        </a>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {

            }
        },
        methods: {
            totalPrice: function () {
                return this.$store.getters.getTotalPrice
            },
            totalQty: function () {
                return this.$store.getters.getTotalQty
            },
        }
    }
</script>

<style scoped>


</style>
