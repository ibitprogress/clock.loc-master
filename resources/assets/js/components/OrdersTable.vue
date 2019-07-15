<template>
    <div>
        <table class="table table-striped table-sm mt-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">№ замовлення</th>
                    <th scope="col">Прізвище / Ім'я</th>
                    <th scope="col">Номер телефону</th>
                    <th scope="col">Загальна ціна</th>
                    <th scope="col">Спосіб оплати</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Дії</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, key) in orders">
                    <th scope="row">{{order.order_id}}</th>
                    <td>
                        {{order.client_last_name}} {{order.client_first_name}}

                    </td>
                    <td>
                        0{{order.phone}}
                    </td>
                    <td>
                        {{order.total_price}}
                    </td>
                    <td v-if='order.pay_method === "cash"'>
                        Готівкою
                    </td>
                    <td v-else-if='order.pay_method === "online"'>
                        Онлайн
                    </td>
                    <td v-else>
                        Невизначено
                    </td>
                    <td>
                        {{order.created_at}}
                    </td>
                    <td>
                        <a class="btn btn-success btn-sm" title="Переглянути" v-bind:href="ordersUrl + '/' + order.order_id" role="button">
                            <i class="far fa-file-alt"></i>
                        </a>
                        <button type="button" class="btn btn-primary btn-sm" title="Позначити як переглянуте" v-if="order.revised === 0" v-on:click="sendUpdate(order.order_id, true)">
                            <i class="far fa-check-square"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                orders: [],
                selectedDeleteClock: ""
            }
        },
        props: ['ordersData', 'ordersUrl'],
        methods: {
            sendUpdate: function (orderId, revisedValue) {
                if(this.wait){
                    return
                }
                this.wait = true;
                setTimeout(() => this.wait = false, 1000);
                let updateUrl = this.ordersUrl + "/" + orderId;
                axios({
                    method: 'post',
                    url: updateUrl,
                    data: {
                        _method: "PUT",
                        revised: revisedValue,
                    }
                })
                    .then(response => {
                        this.updateOrders(response.data);
                        runToastmessage("Зміни успішно внесені в базу даних");
                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors);
                            runToastmessage("Помилка. Зміни не внесені в базу даних", "error");
                    });
            },
            updateOrders: function (data) {
                this.orders = data;
            },
        },
        created: function(){
            this.updateOrders(this.ordersData);
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
</style>
