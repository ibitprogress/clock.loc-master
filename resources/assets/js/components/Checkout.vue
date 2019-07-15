<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h2>{{ trans('localization.checkout')}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="container">
                        <div class="form-group row">
                            <label for="firstName" class="col-sm-4 col-form-label">{{ trans('localization.firstName')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="firstName" v-model="firstName" v-bind:class="{ 'is-invalid': validationErrors.firstName }">
                                <div class="invalid" v-show="validationErrors.firstName">{{ trans('localization.fieldIsRequired')}}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-4 col-form-label">{{ trans('localization.lastName')}}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="lastName" v-model="lastName" v-bind:class="{ 'is-invalid': validationErrors.lastName }">
                                <div class="invalid" v-show="validationErrors.lastName">{{ trans('localization.fieldIsRequired')}}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-4 col-form-label">{{ trans('localization.phone')}}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text pt-0 pb-0">+38</div>
                                    </div>
                                    <input type="tel" class="form-control" id="phone" placeholder="09xxxxxxxx"
                                           autocomplete="tel"
                                           maxlength="10"
                                           pattern="(.){10}" required
                                           v-bind:value="phone"
                                           v-on:input="phoneToInt($event.target.value)"
                                           v-on:change="phoneValide($event.target.value)"
                                           v-bind:class="{ 'is-invalid': validationErrors.phone }">
                                    <div class="invalid" v-show="validationErrors.phone">{{ trans('localization.invalidPhoneNumber')}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-4 pt-0">{{ trans('localization.deliveryMethod')}}</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deliveryMethod" id="novaPoshta" value="novaPoshta" checked v-model="deliveryMethod" v-on:click="warehousUkrposhta = ''">
                                    <label class="form-check-label" for="novaPoshta">
                                        {{ trans('localization.novaPoshta')}}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="deliveryMethod" id="ukrposhta" value="ukrposhta"  v-model="deliveryMethod" v-on:click="updateWarehousesList({})">
                                    <label class="form-check-label" for="ukrposhta">
                                        {{ trans('localization.ukrposhta')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-sm-4 col-form-label">{{ trans('localization.city')}}</label>
                            <div class="col-sm-8" >
                                <div  class="form-control padding-1px" >
                                    <stf-select v-model="city">
                                        <div slot="label">{{ trans('localization.enterYourCity')}}</div>
                                        <div slot="value" >
                                            <div v-if="city">
                                                <span>{{city.MainDescription}}</span>
                                            </div>
                                        </div>
                                        <div slot="search-input">
                                            <input @input="getCityList($event.target.value)">
                                        </div>
                                        <section class="options delivery_order__options" v-if="cityList.Addresses !== undefined">
                                            <stf-select-option
                                                    v-for="item of cityList.Addresses" :key="item.Ref"
                                                    :value="item"
                                                    :class="{'stf-select-option_selected': item.Ref === (city && city.Ref)}">
                                                <span v-if="item.SettlementTypeCode ==='с.'">{{item.MainDescription}} (<small>{{item.Area + ' ' + item.ParentRegionCode + ', ' + item.Region + ' ' + item.RegionTypesCode}}</small>)</span>
                                                <span v-else>{{item.MainDescription}} (<small>{{item.Area + ' ' + item.ParentRegionCode}}</small>)</span>
                                            </stf-select-option>
                                        </section>
                                    </stf-select>
                                </div>


                            </div>
                        </div>

                        <div class="form-group row" v-if="deliveryMethod === 'novaPoshta' && city.Warehouses !== undefined && city.Warehouses > 0">
                            <label for="warehouses" class="col-sm-4 col-form-label">{{ trans('localization.warehous')}}</label>
                            <div class="col-sm-8">
                                <div  class="form-control padding-1px" >
                                    <stf-select v-model="warehousNovaPoshta">
                                        <div slot="label">{{ trans('localization.enterYourCity')}}</div>
                                        <div slot="value" >
                                            <div v-if="warehousNovaPoshta">
                                                <span>{{warehousNovaPoshta.Description}}</span>
                                            </div>
                                        </div>
                                        <div slot="search-input">
                                            <input @input="filterWarehousesList($event.target.value)">
                                        </div>
                                        <section class="options delivery_order__options">
                                            <stf-select-option
                                                    v-for="item of warehousesFilterList" :key="item.Ref"
                                                    :value="item"
                                                    :class="{'stf-select-option_selected': item.Ref === (warehousNovaPoshta && warehousNovaPoshta.Ref)}">
                                                <span>{{item.Description}}</span>
                                            </stf-select-option>
                                        </section>
                                    </stf-select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" v-if="deliveryMethod === 'ukrposhta'">
                            <label for="warehousesUkrposhta" class="col-sm-4 col-form-label">{{ trans('localization.warehous')}}</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="warehousesUkrposhta" v-model="warehousUkrposhta">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-4 pt-0">{{ trans('localization.paymentMethod')}}</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCash" value="cash" checked v-model="payMethod">
                                    <label class="form-check-label" for="paymentCash">
                                        {{ trans('localization.paymentCash')}}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentOnline" value="online" v-model="payMethod">
                                    <label class="form-check-label" for="paymentOnline">
                                        {{ trans('localization.paymentOnline')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-12 col-md-6 offset-lg-1 col-lg-5">
                <div class="container-fluid">
                    <h4>{{ trans('localization.in_the_cart')}}</h4>
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr v-for="item in items">
                                <td class="logo-cell">
                                    <a :href="shopUrl+item.clockId" target="_blank">
                                        <img :src="imagesPath+item.logo_uuid" class="img-fluid img-thumbnail logo" alt="Responsive image">
                                    </a>
                                </td>
                                <td>
                                    <div class="product-name">
                                        <a :href="shopUrl+item.clockId" target="_blank">{{item.name}}</a></div>
                                    <div class="d-flex justify-content-between">
                                        <span class="product-qty">{{item.qty}} шт.</span>
                                        <span class="total-price">{{item.total}} грн</span>
                                    </div>
                                </td>
                            </tr>
                            <tr >
                                <td></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span class="d-inline-flex check-total-title">{{ trans('localization.cartTotal')}}: </span>
                                        <span class="d-inline-flex check-total">{{totalPrice}} грн</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row justify-content-center">
                        <a class="btn btn-link" href="#"  data-toggle="modal" data-target="#cartModal">{{ trans('localization.editCart')}}</a>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <button class="btn btn-lg btn-success" v-on:click="createOrder">{{ trans('localization.confirmOrder')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="errorOrder" tabindex="-1" role="dialog" aria-labelledby="successOrder" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="errorOrderTitle">{{ trans('localization.errorOrder')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ trans('localization.errorOrderText')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('localization.ok')}}</button>
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
                firstName: "",
                lastName: "",
                phone: "",
                deliveryMethod: "novaPoshta",
                city: "",
                warehousNovaPoshta: "",
                warehousUkrposhta: "",
                warehousesList: {},
                warehousesFilterList:{},
                cityList: {
                    Addresses: [],
                    TotalCount: 0
                },
                payMethod: "cash",
                validationErrors: {
                    firstName: false,
                    lastName: false,
                    phone: false,
                }
            }
        },
        props: ['imagesPath', 'shopUrl', 'cartUrl', 'newOrderUrl', 'checkoutSuccessUrl'],
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
        watch: {
            city: function (newCity, oldCity) {
                this.getWarehousesList(newCity.DeliveryCity)

            }
        },
        methods:{
            phoneToInt: function (phone) {
                phone = phone.replace(/[^0-9]/g,'');
                this.phone = phone;
                this.$forceUpdate();
            },
            phoneValide: function (phone) {
                if (phone.length == 10 && phone < 1000000000){
                    this.validationErrors.phone = false;
                } else {
                    this.phone = "";
                    this.validationErrors.phone = true;
                }
            },
            getCityList: function (str) {
                if (str.length >=3){
                    let data = {
                        "modelName": "Address",
                        "calledMethod": "searchSettlements",
                        "methodProperties": {
                            "CityName": str,
                            "Limit": 50
                        },
                    }
                    data = JSON.stringify(data);
                    let settings = {
                        "async": true,
                        "crossDomain": true,
                        "url": "https://api.novaposhta.ua/v2.0/json/",
                        "method": "POST",
                        "headers": {
                            "content-type": "application/json",
                        },
                        "processData": false,
                        "data": data,
                    }
                    $.ajax(settings).done((response) => {if (response.errors.length == 0) this.updateCityList(response.data[0])});
                }
            },
            getWarehousesList: function(ref) {
                if (ref !== undefined && ref !== ""){
                    axios.post('/nova-poshta/get-warehouses', {
                        ref: ref
                    })
                        .then((response) => {
                            this.updateWarehousesList(response.data);
                        })
                }

            },
            filterWarehousesList: function(text){
                let data;
                if (text === "") data = this.warehousesList;
                else {
                    data = this.warehousesList.filter(function (value){
                        if (value.Number.startsWith(text) === true) return value;
                    })
                }
                this.warehousesFilterList = data;

            },

            updateCityList: function (list) {
                this.cityList = list;
                this.city = "";
                this.warehousesList = {};
                this.warehousNovaPoshta = "";
            },
            updateWarehousesList: function(list) {
                this.warehousesList = list;
                this.warehousesFilterList = list;
                this.warehousNovaPoshta = "";
            },
            createOrder: function () {
                if (this.validation()) {
                    let warehous = this.warehousNovaPoshta || this.warehousUkrposhta;
                    console.log(this.newOrderUrl);
                    axios.post(this.newOrderUrl, {
                        firstName: this.firstName,
                        lastName: this.lastName,
                        phone: this.phone,
                        deliveryMethod: this.deliveryMethod,
                        city: JSON.stringify(this.city),
                        warehous: JSON.stringify(warehous),
                        payMethod: this.payMethod,
                    })
                        .then((response) => {
                            document.location.href = this.checkoutSuccessUrl;
                        })
                        .catch(function (error) {
                            console.log(error);
                            $('#errorOrder').modal()
                        });
                }
            },
            validation: function(){
                let data = true;
                if (this.firstName == '') {
                    this.validationErrors.firstName = true;
                    data = false;
                } else this.validationErrors.firstName = false;
                if (this.lastName == ''){
                    this.validationErrors.lastName = true;
                    data = false;
                } else this.validationErrors.lastName = false;
                if (this.phone.length != 10 || isNaN(this.phone) || this.phone >= 1000000000){
                    this.validationErrors.phone = true;
                    data = false;
                } else this.validationErrors.phone = false;
                return data;
            },
        }
    }
</script>

<style scoped>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .col-form-label{
        font-size: 1.1em;
    }
    .logo{
        height: 50px;
        width: 50px;
        padding: 2px;
    }
    .logo-cell{
        width: 65px;
    }
    .product-name{
        font-family: 'Roboto Condensed', sans-serif;
        font-size: 1em;
    }
    .check-total-title{
        font-size: 1.2em;
        font-weight: 600;
    }
    .check-total{
        font-size: 1.4em;
        font-weight: 600;
    }
    .invalid {
             width: 100%;
             margin-top: 0.25rem;
             font-size: 80%;
             color: #dc3545
         }
    .modal-header {
        color: white;
    }

</style>