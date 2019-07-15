<template>
    <div>
        <table class="table table-striped table-sm mt-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ім'я</th>
                    <th scope="col">Номер телефону</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Дії</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(feedback, key) in feedbacks">
                    <th scope="row">{{feedback.feedback_id}}</th>
                    <td>
                        {{feedback.first_name}}

                    </td>
                    <td>
                        0{{feedback.phone}}
                    </td>
                    <td v-if='feedback.revised === 0' class="text-success">
                        Новий
                    </td>
                    <td v-else-if='feedback.revised === 1'>
                        Переглянуто
                    </td>
                    <td v-else>
                        Невизначено
                    </td>
                    <td>
                        {{feedback.created_at}}
                    </td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm" title="Позначити як переглянуте" v-if="feedback.revised === 0" v-on:click="sendUpdate(feedback.feedback_id, true)">
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
                feedbacks: [],
                selectedDeleteClock: ""
            }
        },
        props: ['feedbacksData', 'feedbacksUrl'],
        methods: {
            sendUpdate: function (feedbackId, revisedValue) {
                if(this.wait){
                    return
                }
                this.wait = true;
                setTimeout(() => this.wait = false, 1000);
                let updateUrl = this.feedbacksUrl + "/" + feedbackId;
                axios({
                    method: 'post',
                    url: updateUrl,
                    data: {
                        _method: "PUT",
                        revised: revisedValue,
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            this.updateOrders(response.data);
                            runToastmessage("Зміни успішно внесені в базу даних");
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors);
                        runToastmessage("Помилка. Зміни не внесені в базу даних", "error");
                    });
            },
            updateOrders: function (data) {
                this.feedbacks = data;
            },
        },
        created: function(){
            this.updateOrders(this.feedbacksData);
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
