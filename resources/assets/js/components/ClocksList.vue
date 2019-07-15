<template>
    <div>
        <div class="container">
            <div class="row justify-content-start d-lg-none">
                <div class="col-3 text-center">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="true" aria-controls="collapseFilters"><i class="fas fa-filter"></i> Фильтр</button>
                </div>

            </div>
            <div class="row">
                <div id="collapseFilters" class="col-12 col-lg-3 collapse d-lg-block">
                    <filters v-bind:filter="filter"
                             v-on:query="sendUpdate($event)">

                    </filters>
                </div>
                <div class="col-12 col-lg-9 ">
                    <div class="row ">


                        <div class="col-6 col-md-4 mt-3" v-for="(clock, index) in clocks">
                            <div class="card h-100">
                                <a v-bind:href="shopUrl +'/' + clock.clock_id">
                                    <img class="card-img-top" v-if="clock.logo_uuid !== null" :src="imagesPath + clock.logo_uuid" alt="Card image cap">
                                    <img class="card-img-top" v-else :src="imagesPath + '../'+'no_image.png'" alt="Card image cap">
                                </a>
                                <div class="card-body px-2 pb-2">
                                    <a v-bind:href="shopUrl +'/' + clock.clock_id">
                                        <h5 class="card-title clock-name">{{clock.name}}</h5>
                                    </a>
                                    <div class="feedbacks d-flex mb-2">
                                        <div class="stars mr-auto">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <!--<div class="comments">-->
                                            <!--<a href="#">-->
                                                <!--<i class="far fa-comments mr-2"></i>{{ trans('localization.comments')}} 0-->
                                            <!--</a>-->
                                        <!--</div>-->
                                    </div>
                                    <div class="prices-wrapper d-flex">
                                        <div class="prices d-flex flex-column mr-auto justify-content-end">
                                            <span class="old-price text-secondary" v-if="clock.old_price !== 0">{{clock.old_price}} грн</span>
                                            <span class="price">{{clock.price}} грн</span>
                                        </div>
                                        <div class="button-wrapper d-flex align-items-end">
                                            <button class="btn btn-success" data-toggle="modal" data-target="#cartModal" v-on:click="addToCart(clock.clock_id)">{{ trans('localization.bay') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
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
                clocks: this.clocksData
            }
        },
        props:['imagesPath', 'clocksData', 'filter', 'filterUrl', 'mainUrl', 'shopUrl', 'cartUrl'],
        methods: {
            sendUpdate: function (query) {
                let stringUrl = this.filterUrl +'?' + query;
                let shopUrl = this.shopUrl;
                axios.get(stringUrl)
                    .then(response => (this.clocks = response.data.clocks))
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        if (query == ""){
                            history.pushState('Best Time', 'Best Time', '/');
                        }else{
                            let newUrl = shopUrl + '?' + query;
                            history.pushState('Best Time', 'Best Time', newUrl);
                        }
                    });
            },
            addToCart: function (clockId) {
                this.$store.dispatch('addToCart', clockId);
            }
        },


    }
</script>

<style scoped>
    .card:hover{
        box-shadow: 0 0 10px #aaa;
    }
    .feedbacks {
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }
    .clock-name{
        font-family: "Roboto Condensed", sans-serif;
        color: #212529;
    }
    .stars{
        color: #ffc107;
    }
    .comments{
        font-size: 0.9em;
    }
    .old-price{
        text-decoration: line-through;
    }
    .price{
        font-size: 1.5em;
        line-height: 1;
    }
    .prices-wrapper{
        height: 3.2em;
    }

</style>
