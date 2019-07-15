<template>
    <div>
        <table class="table table-striped table-sm mt-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Назва годинника</th>
                    <th scope="col">Виробник</th>
                    <th scope="col" class="price-column">Ціна</th>
                    <th scope="col" class="price-column">Стара ціна</th>
                    <th scope="col">Наявність</th>
                    <th scope="col">Приховати</th>
                    <th scope="col" class="edit-column">Дії</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(clock, key) in clocks">
                    <th scope="row">{{clock.clock_id}}</th>
                    <td><a v-bind:href="shopUrl+'/'+clock.clock_id">{{clock.name}}</a></td>
                    <td>{{clock.producer}}</td>
                    <td class="price-column">
                        <input class="form-control form-control-sm" type="number" v-model="clock.price" v-on:input="toInt(clock); setUpdate(clock);">
                    </td>
                    <td class="price-column">
                        <input class="form-control form-control-sm" type="number" v-model="clock.old_price" v-on:input="toInt(clock); setUpdate(clock);">
                    </td>
                    <td>
                        <select class="form-control form-control-sm" name="availability" id="availability" v-model="clock.availability" v-on:change="setUpdate(clock)">
                            <option value="yes">В наявності</option>
                            <option value="no">Немає в наявності</option>
                            <option value="soon">Незабаром буде</option>
                            <option value="by-order">Під замовлення</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control form-control-sm" name="hide" id="hide" v-model="clock.hide" v-on:change="setUpdate(clock)">
                            <option value="0" selected>Ні</option>
                            <option value="1">Так</option>
                        </select>
                    </td>
                    <td class="edit-column">
                        <button type="button" class="btn btn-danger btn-sm" title="Видалити годинник" v-on:click="showDeleteModal(clock)">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        <a class="btn btn-primary btn-sm" v-bind:href="'clocks/' + clock.clock_id + '/edit'" role="button">
                            <i class="far fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-success btn-sm" title="Обновити цей параметр" v-show="clock.updated_at == 'now'" v-on:click="sendUpdate(clock)">
                            <i class="far fa-save"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
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
                            <button type="button" class="btn btn-danger" data-toggle="modal" v-on:click="sendDestroy(selectedDeleteClock)">Видалити</button>
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
                clocks: [],
                selectedDeleteClock: ""
            }
        },
        props: ['clocksData', 'clocksUrl', 'shopUrl'],
        methods: {
            toInt: function (clock) {
                clock.price = parseInt(clock.price, 10);
                clock.old_price = parseInt(clock.old_price, 10);
            },
            sendUpdate: function (clock) {
                if(this.wait){
                    return
                }
                this.wait = true;
                setTimeout(() => this.wait = false, 1000);
                let updateUrl = this.clocksUrl + "/" + clock.clock_id+"/update";
                axios({
                    method: 'post',
                    url: updateUrl,
                    data: {
                        _method: "PUT",
                        clockId: clock.clock_id,
                        name: clock.name,
                        gender: clock.gender,
                        typeOfIndexation: clock.type_of_indexation,
                        typeOfMechanism: clock.type_of_mechanism,
                        producer: clock.producer,
                        availability: clock.availability,
                        hide: clock.hide,
                        price: clock.price,
                        oldPrice: clock.old_price,
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            this.clocks = response.data;
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
            showDeleteModal:function (clock){
                $('#deleteModal').modal('show');
                this.selectedDeleteClock = clock;
            },
            sendDestroy: function (clock) {
                $('#deleteModal').modal('hide');
                this.selectedDeleteClock = "";
                if(this.wait){
                    return
                }
                this.wait = true;
                setTimeout(() => this.wait = false, 1000);
                let url = clocksUrl + "/" + clock.clock_id +"/destroy";
                axios({
                    method: 'post',
                    url: url,
                    data: {
                        _method: "DELETE",
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            this.clocks = response.data;
                            runToastmessage("Годинник успішно видалений з бази даних");
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        runToastmessage("Невідома помилка", "error");
                    });
            },
            setUpdate: function (clock) {
                clock.updated_at = "now";
             },
        },
        created: function(){
            this.clocks = this.clocksData;
        },


    }
</script>

<style scoped>
    form {
        margin-top: 1.2em;
    }
    #deleteModal h5 {
        color: white;
    }
    .price-column{
        max-width: 90px;
    }
    .edit-column{
        width: 110px;
    }
</style>
