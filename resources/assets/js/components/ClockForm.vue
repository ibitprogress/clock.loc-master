<template>
    <div>
        <form method="POST" id="clockForm" action="/admin/clocks">
            <input type="hidden" name="_token" :value="csrf">

            <div class="form-group row">
                <label class="col-3 col-form-label" for="name">Назва годинника</label>
                <div class="col-4">
                    <input type="text" class="form-control" name="name" id="name" v-model="name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="gender">Стать</label>
                <div class="col-4">
                    <select class="form-control" name="gender" id="gender" v-model="gender">
                        <option value="men">Чоловічі</option>
                        <option value="women">Жіночі</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="typeOfIndexation">Тип індексації</label>
                <div class="col-4">
                    <select class="form-control" name="typeOfIndexation" id="typeOfIndexation"
                            v-model="typeOfIndexation">
                        <option value="strelochnye">Стрілочна</option>
                        <option value="cifrovye">Цифрова</option>
                        <option value="strelochnyePlusCifrovye">Комбіновані</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="typeOfMechanism">Тип механізму</label>
                <div class="col-4">
                    <select class="form-control" name="typeOfMechanism" id="typeOfMechanism" v-model="typeOfMechanism">
                        <option value="quartz">Кварцовий</option>
                        <option value="mehanicheskie">Механічний</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="producer">Виробник</label>
                <div class="col-4">
                    <input type="text" class="form-control" name="producer" id="producer" v-model="producer">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="price">Ціна, грн</label>
                <div class="col-4">
                    <input type="number" step="1" class="form-control" name="price" id="price" v-model="price"
                           v-on:input="toInt">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="oldPrice">Стара ціна, грн</label>
                <div class="col-4">
                    <input type="number" step="1" class="form-control" name="oldPrice" id="oldPrice" v-model="oldPrice"
                           v-on:input="toInt">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="availability">Наявність</label>
                <div class="col-4">
                    <select class="form-control" name="availability" id="availability" v-model="availability">
                        <option value="yes">В наявності</option>
                        <option value="no">Немає в наявності</option>
                        <option value="soon">Незабаром буде</option>
                        <option value="byOrder">Під замовлення</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label" for="hide">Приховати</label>
                <div class="col-4">
                    <select class="form-control" name="hide" id="hide" v-model="hide">
                        <option value="0" selected>Ні</option>
                        <option value="1">Так</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="form-group ">
            <button type="submit" class="btn btn-primary" v-if="update == false" form="clockForm">Створити</button>
            <button class="btn btn-success" v-if="update == true" v-on:click="sendUpdate">Редагувати</button>
            <button class="btn btn-danger" v-if="update == true" v-on:click="showDeleteModal">Видалити</button>
        </div>
        <div id="deleteModal" class="modal fade" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">Увага</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Ви дійсно бажаєте видалити цей товар із бази даних?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Ні</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" v-on:click="sendDestroy()">Видалити</button>
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
                clockId: 0,
                update: false,
                name: null,
                gender: "men",
                typeOfIndexation: "strelochnye",
                typeOfMechanism: "quartz",
                producer: null,
                availability: "yes",
                hide: 0,
                price: 0,
                oldPrice: 0,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        props: ["clockData", "updateUrl"],
        methods: {
            toInt: function (event) {
                let targetId = event.currentTarget.id;
                this[targetId] = parseInt(this[targetId], 10);
            },
            sendUpdate: function () {
                let updateUrl = this.updateUrl;
                axios({
                    method: 'post',
                    url: updateUrl,
                    data: {
                        _method: 'PUT',
                        clockId: this.clockId,
                        name: this.name,
                        gender: this.gender,
                        typeOfIndexation: this.typeOfIndexation,
                        typeOfMechanism: this.typeOfMechanism,
                        producer: this.producer,
                        availability: this.availability,
                        hide: this.hide,
                        price: this.price,
                        oldPrice: this.oldPrice,
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            let resetData = response.data;
                            this.resetData(resetData);
                            runToastmessage("Зміни успішно внесені в базу даних");
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors)
                        for (let key in errors) {
                            runToastmessage(errors[key][0], "error");
                        }
                    });
            },
            showDeleteModal:function (){
                $('#deleteModal').modal('show');
            },
            sendDestroy: function () {
                $('#deleteModal').modal('hide');
                let destroyUrl = this.updateUrl;
                axios({
                    method: 'post',
                    url: destroyUrl,
                    data: {
                        _method: 'DELETE',
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            window.location.href = "/admin/clocks"
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors)
                        runToastmessage("Невідома помилка", "error");
                    });

            },
            resetData: function (data) {
                if (data !== undefined) {
                    console.log (data)
                    this.update = true;
                    this.clockId = data.clock_id;
                    this.name = data.name;
                    this.gender = data.gender;
                    this.typeOfIndexation = data.type_of_indexation;
                    this.typeOfMechanism = data.type_of_mechanism;
                    this.producer = data.producer;
                    this.availability = data.availability;
                    this.hide = data.hide;
                    this.price = data.price;
                    this.oldPrice = data.old_price;
                };
            }
        },
        created() {
            let data = this.clockData
            this.resetData(data);
        }


    }
</script>

<style scoped>
    form {
        margin-top: 1.2em;
    }
</style>
