<template>
    <div>
        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModal" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title">{{ trans('localization.feedback')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="container-fluid">
                            <p>{{ trans('localization.feedbackProposition')}}</p>
                            <form>
                                <div class="form-group">
                                    <label for="feedbackFirstName">{{ trans('localization.firstName')}}</label>
                                    <input type="text" class="form-control" id="feedbackFirstName" v-model="firstName" v-bind:class="{ 'is-invalid': validationErrors.firstName }">
                                    <div class="invalid" v-show="validationErrors.firstName">{{ trans('localization.fieldIsRequired')}}</div>
                                </div>
                                <div class="form-group">
                                    <label for="feedbackPhone">{{ trans('localization.phone')}}</label>
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
                                <a href="#" class="btn btn-success btn-lg w-100 px-0" role="button" v-on:click="createFeedback">{{ trans('localization.callMeBack')}}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="successFeedback" tabindex="-1" role="dialog" aria-labelledby="successFeedback" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title">{{ trans('localization.feedback')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ trans('localization.successFeedback')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="errorFeedback" tabindex="-1" role="dialog" aria-labelledby="errorFeedback" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">{{ trans('localization.feedback')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ trans('localization.errorFeedback')}}</p>
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
                phone: "",
                firstName: "",
                validationErrors: {
                    firstName: false,
                    phone: false,
                }

            }
        },
        props: ['feedbackUrl'],
        methods: {
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
            validation: function(){
                let data = true;
                if (this.firstName == '') {
                    this.validationErrors.firstName = true;
                    data = false;
                } else this.validationErrors.firstName = false;
                if (this.phone.length != 10 || isNaN(this.phone) || this.phone >= 1000000000){
                    this.validationErrors.phone = true;
                    data = false;
                } else this.validationErrors.phone = false;
                return data;
            },
            createFeedback: function () {
                if(this.wait){
                    return
                }
                this.wait = true;
                setTimeout(() => this.wait = false, 1000);
                $('#feedbackModal').modal('hide');
                if (this.validation()) {
                    axios.post(this.feedbackUrl, {
                        firstName: this.firstName,
                        phone: this.phone,
                    })
                        .then((response) => {
                            this.firstName = "";
                            this.phone = "";
                            $('#successFeedback').modal('show')
                        })
                        .catch(function (error) {
                            console.log(error);
                            $('#errorFeedback').modal('show')
                        });
                }
            },


        }
    }
</script>

<style scoped>
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