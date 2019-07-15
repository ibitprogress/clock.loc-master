<template>
    <div>
        <div class="container mt-3">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="logo-block">
                        <template >
                            <div class="slider slider-for">
                                <div v-for="image in clockData.images">
                                    <img :src="'/images/large/' + image.uuid" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="slider slider-nav mx-4">
                                <div v-for="image in clockData.images">
                                    <img class="mx-auto" :src="'/images/small/' + image.uuid" alt="">
                                </div>
                            </div>
                        </template>

                    </div>

                </div>
                <div class="col-12 col-sm-6 ">
                    <div class="title-container border-bottom">
                        <h1 class="mb-0">{{ clockData.name }}</h1>
                    </div>
                    <div class="d-flex flex-row mt-2">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <!--<div class="comments ml-5">-->
                            <!--<a href="#" v-if="clockData.comments == null">-->
                                <!--<i class="far fa-comments mr-2"></i>{{ trans('localization.writeComments')}}-->
                            <!--</a>-->
                            <!--<a href="#" v-else>-->
                                <!--<i class="far fa-comments mr-2"></i>{{ trans('localization.comments')}} 0-->
                            <!--</a>-->
                        <!--</div>-->
                    </div>
                    <div class="d-flex flex-row justify-content-between mt-4 mb-4">
                        <div>
                            <span class="availability-title">{{trans('localization.availability')}}: </span>
                            <span class="availability text-success" v-if="clockData.availability == 'yes'">{{trans('localization.availabilityYes')}}</span>
                            <span class="availability text-danger" v-if="clockData.availability == 'no'">{{trans('localization.availabilityNo')}}</span>
                            <span class="availability text-warning" v-if="clockData.availability == 'soon'">{{trans('localization.availabilitySoon')}}</span>
                            <span class="availability text-danger" v-if="clockData.availability == 'byOrder'">{{trans('localization.availabilityByOrder')}}</span>
                        </div>

                        <div class="product-code"><span><strong>{{trans('localization.productCode')}}:</strong> {{clockData.clock_id}}</span></div>
                    </div>
                    <div class="row">
                        <div class="prices d-flex flex-column justify-content-center col-6 col-lg-4 ">
                            <span class="old-price text-secondary" v-if="clockData.old_price !== 0">{{clockData.old_price}} грн</span>
                            <span class="price">{{clockData.price}} грн</span>
                        </div>
                        <div class="button-wrapper d-flex align-items-end col-6 col-lg-4">
                            <button class="btn btn-success btn-lg w-100 h-100" data-toggle="modal" data-target="#cartModal" v-on:click="addToCart(clockData.clock_id)">
                                <i class="fas fa-shopping-cart"></i> {{ trans('localization.bay') }}</button>
                        </div>
                    </div>
                    <div class="row border mt-5">
                        <div class="col-12 delivery">
                            <i class="fas fa-truck icon"></i> {{ trans('localization.delivery') }}:
                        </div>
                        <div class="col-5 offset-1">
                            <div class="delivery-info">
                                <p class="delivery-service-name">{{ trans('localization.novaPoshta') }}</p>
                                <p class="delivery-details">{{ trans('localization.gettingNovaPoshta') }}</p>
                            </div>
                        </div>
                        <div class="col-5 offset-1">
                            <div class="delivery-info">
                                <p class="delivery-service-name">{{ trans('localization.ukrposhta') }}</p>
                                <p class="delivery-details">{{ trans('localization.gettingUkrposhta') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row border border-top-0">
                        <div class="col-12">
                            <p class="payment"><i class="far fa-credit-card icon"></i>{{ trans('localization.payment') }}:</p>
                            <p class="payment-info">{{ trans('localization.paymentInfo') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <ul class="nav nav-tabs col-12 mt-5" id="tabList" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="descriptions-tab" data-toggle="tab" href="#descriptions" role="tab" aria-controls="descriptions" aria-selected="true">{{ trans('localization.itemDescriptions')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="characteristics-tab" data-toggle="tab" href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="false">{{ trans('localization.itemCharacteristics')}}</a>
                    </li>
                    <!--<li class="nav-item">-->
                        <!--<a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">{{ trans('localization.itemComments')}}</a>-->
                    <!--</li>-->
                </ul>
                <div class="tab-content col-6" id="myTabContent">
                    <div class="tab-pane fade  show active" id="descriptions" role="tabpanel" aria-labelledby="descriptions-tab">
                        <descriptions v-bind:descriptions="clockData.descriptions[clockData.language]"
                                      v-bind:name="clockData.name"
                                      v-bind:language="clockData.language"
                        ></descriptions>
                    </div>
                    <div class="tab-pane fade" id="characteristics" role="tabpanel" aria-labelledby="characteristics-tab">
                        <characteristics v-bind:clock-data="clockData"></characteristics>

                    </div>
                    <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {

            }
        },
        props:['clockData', 'language'],
        methods: {
            addToCart: function (clockId) {
                this.$store.dispatch('addToCart', clockId);
            }
        },
    }

    $(document).ready(function(){
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav',
        });
        if($('.slider-nav div').length > 1) {
            $('.slider-nav').show();
            $('.slider-nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                touchMove: false,
                asNavFor: '.slider-for',
                infinite: false,
                dots: false,
                focusOnSelect: true,
                focusOnChange: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 360,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        } else {
            $('.slider-nav').hide();
        }


    });
</script>

<style scoped>
    .slider-nav img{
        height: 90px;
        width: 90px;
    }

    .stars{
        color: #ffc107;
    }
    .availability-title, .availability{
        font-weight: 600;
    }

    .old-price{
        text-decoration: line-through;
    }
    .price{
        font-size: 2em;
        line-height: 1;
    }
    .delivery, .payment{
        font-size: 1.2em;
        font-weight: 600;
        margin-bottom: 0.5em;

    }
    .icon {
        color: #e62633;
        margin-right: 0.5em;
    }
    .delivery-service-name{
        font-weight: 600;
        margin: 0;
    }

</style>