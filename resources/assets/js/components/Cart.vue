<template>
    <div class="modal" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModal" aria-hidden="true">

        <div class="modal-dialog modal-size">
            <div class="modal-content">
                <template v-if="totalQty !==0">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('localization.cart')}}</h5>
                        <button type="button btn-lg" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                            <div class="container">
                                    <template v-for="item in items">
                                        <div class="row border py-2 mb-2">
                                            <div class="col-4 col-md-2 order-0"><img :src="imagesPath+item.logo_uuid" class="img-fluid img-thumbnail" alt="Responsive image"></div>
                                            <div class="col-6 col-md-4 order-1">
                                                <p class="product-name">{{item.name}}</p>
                                                <p class="price">{{item.price}} грн/шт.</p>
                                                <p class="product-detail">{{ trans('localization.productCode')}}: {{item.clockId}}</p>
                                            </div>
                                            <div class="col-8 offset-4 offset-md-0 col-md-3 align-self-center order-3 amount">
                                                <a href="#" class="btn cart-amount-button" name="minus"v-on:click="minusOneFromCart(item)"><i class="fas fa-minus"></i></a>
                                                <input name="quantity" type="text" class="form-control cart-amount-input-text" v-bind:value="item.qty">
                                                <a href="#" class="btn cart-amount-button" name="plus" v-on:click="plusOneToCart(item)"><i class="fas fa-plus"></i></a>
                                                <span class="cart-amount-text">шт.</span>
                                            </div>
                                            <div class="col-8 offset-4 offset-md-0 col-md-2 price-total align-self-center order-4">{{item.total}} грн</div>
                                            <div class="col-2 col-md-1 order-2 order-md-4 d-flex justify-content-end align-items-start">
                                                <button type="button" class="btn btn-outline-danger border-0" name="remove" v-on:click="removeFromCart(item)"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </template>
                                <div class="d-flex justify-content-end">
                                    <span class="cart-total">{{ trans('localization.cartTotal')}}: {{totalPrice}} грн</span>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-5 mb-1">
                                    <button type="button" class="btn btn-outline-primary btn-lg w-100 px-0" data-dismiss="modal">{{ trans('localization.backToShop')}}</button>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-5 offset-lg-2 mb-1">
                                    <a v-if="currentUrl !== '/checkout'" :href="checkoutUrl" class="btn btn-success btn-lg w-100 px-0" role="button">{{ trans('localization.toOrder')}}</a>
                                    <a v-else href="#" class="btn btn-success btn-lg w-100 px-0" role="button" data-dismiss="modal">{{ trans('localization.toOrder')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>

                                <div class="modal-header border-bottom-0">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h2 class="cart-empty"><i class="fas fa-shopping-cart"></i> {{ trans('localization.cartEmpty')}}</h2>
                                </div>

                </template>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Cart",
        data: function () {
            return {
                currentUrl: window.location.pathname,
            }
        },
        props: ['imagesPath', 'checkoutUrl', 'itemsData', 'totalPriceData', 'totalQtyData'],
        computed: {
            totalPrice () {
                return this.$store.getters.getTotalPrice
            },
            totalQty () {
                return this.$store.getters.getTotalQty
            },
            items () {
                return this.$store.getters.getItems
            },
        },
        methods: {
            uploadToStore: function () {
                if (!(!!window.performance && window.performance.navigation.type === 2)) {
                    this.$store.commit('updateData', {
                        items: this.itemsData,
                        totalPrice: this.totalPriceData,
                        totalQty: this.totalQtyData,
                    });
                } else this.$store.dispatch('getCart');
            },
            plusOneToCart: function(item){
                this.$store.dispatch('updateQty', {
                    clockId: item.clockId,
                    qty: item.qty + 1
                });
            },
            minusOneFromCart: function (item) {
                if (item.qty > 1) {
                    this.$store.dispatch('updateQty', {
                        clockId: item.clockId,
                        qty: item.qty - 1
                    });
                }
            },
            removeFromCart: function (item) {
                this.$store.dispatch('removeFromCart', {
                    clockId: item.clockId
                });
            }

        },
        created: function(){
            this.uploadToStore();
        }
    }
</script>

<style scoped>
    .product-name{
        font-size: 1.1em;
        color: #343a40;
    }
    .product-detail{
        font-size: 0.9em;
    }
    .price{
        font-size: 1em;
    }
    .price-total{
        font-size: 1.2em;
    }
    .product-name, .product-detail, .price, .amount{
        margin-bottom: 0.4em;
    }
    .cart-amount-input-text{
        width: 40px;
        display: inline-block;
        padding: 2px 4px;
        font-size: 1.2em;
        line-height: 0;
        text-align: center;

    }
    .cart-amount-button{
        border: none;
        font-size: 1.2em;
        line-height: 0;
        padding: 0 4px;
        vertical-align: unset ;
        color: #6c757d;
    }
    .cart-amount-button:hover {
        color: #343a40;
    }
    .cart-amount-text{
        font-size: 1.2em;
    }
    th, td {
        text-align: center;
        vertical-align: middle;
    }
    .cart-empty{
        text-align: center;
        height: 100px;
    }
    .cart-total{
        font-size: 1.2em;
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .modal-size {
            width: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }

    @media (min-width: 768px) {
        .modal-size {
            max-width: 740px !important;
        }
    }

</style>