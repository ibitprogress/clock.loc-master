<template>
    <div id="characteristicsForm">
        <p class="h6 text-primary mb-4">Механізм</p>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="кharakterystykaMekhanizmu">Характеристика механізму</label>
            <div class="col-9">
                <input type="text" class="form-control" name="кharakterystykaMekhanizmu" id="кharakterystykaMekhanizmu" v-model="characteristics.кharakterystykaMekhanizmu">
            </div>
        </div>
        <hr>
        <p class="h6 text-primary mb-4">Функції</p>

        <div class="form-group row">
            <div class="col-6">
                <textarea class="form-control" rows="4" placeholder="uk" v-model="functions.value_uk"></textarea>
            </div>
            <div class="col-6">
                <textarea class="form-control" rows="4" placeholder="ru" v-model="functions.value_ru"></textarea>
            </div>
        </div>
        <hr>
        <p class="h6 text-primary mb-4">Корпус</p>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="bodyMaterial">Матеріал корпусу</label>
            <div class="col-4">
                <select class="form-control" name="bodyMaterial" id="bodyMaterial" v-model="characteristics.bodyMaterial">
                    <option value="" selected></option>
                    <option value="polikarbonat">Полікарбонат</option>
                    <option value="splavMetaliv">Сплав металів</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="glass">Скло</label>
            <div class="col-4">
                <select class="form-control" name="glass" id="glass" v-model="characteristics.glass">
                    <option value="" selected></option>
                    <option value="mineralne">Мінеральне</option>
                    <option value="sapfirove">Сапфірове</option>
                    <option value="polikarbonatne">Полікарбонатне</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="style">Стиль</label>
            <div class="col-4">
                <select class="form-control" name="style" id="style" v-model="characteristics.style">
                    <option value=""></option>
                    <option value="klasychnyy">Класичний</option>
                    <option value="sportyvnyy">Спортивний</option>
                </select>
            </div>
        </div>

        <hr>
        <p class="h6 text-primary mb-4">Ремінець</p>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="strapMaterial">Матеріал ремінця</label>
            <div class="col-4">
                <select class="form-control" name="strapMaterial" id="strapMaterial" v-model="characteristics.strapMaterial">
                    <option value=""></option>
                    <option value="kauchukovyy">Каучуковий</option>
                    <option value="shkiryanyy">Шкіряний</option>
                    <option value="stalnyy">Стальний</option>
                </select>
            </div>
        </div>

        <hr>
        <p class="h6 text-primary mb-4">Габарити</p>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="diametr">Діаметр</label>
            <div class="col-4">
                <input type="number" step="1" class="form-control" name="diametr" id="diametr" v-model="characteristics.diametr" v-on:input="toInt">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-3 col-form-label" for="tovshchyna">Товщина</label>
            <div class="col-4">
                <input type="number" step="1" class="form-control" name="tovshchyna" id="tovshchyna" v-model="characteristics.tovshchyna" v-on:input="toInt">
            </div>
        </div>

        <hr>

        <div class="form-group ">
            <button class="btn btn-success" v-on:click="sendUpdate">Зберегти</button>
        </div>
    </div>

</template>

<script>
    export default {
        data: function () {
            return {
                characteristics: {
                    кharakterystykaMekhanizmu: "",
                    bodyMaterial: "",
                    glass: "",
                    style: "",
                    strapMaterial: "",
                    diametr: 0,
                    tovshchyna: 0
                },
                functions: {
                    value_uk: "",
                    value_ru: "",
                }
            }
        },
        props:['characteristicsData', 'functionsData', 'updateUrl'],
        methods: {
            toInt: function (event) {
                let targetId = event.currentTarget.id;
                this[targetId] = parseInt(this[targetId], 10);
            },
            sendUpdate: function () {
                window.wait;
                let updateUrl = this.updateUrl;
                axios({
                    method: 'post',
                    url: updateUrl,
                    data: {
                        _method: 'PUT',
                        characteristics: this.characteristics,
                        functions: this.functions
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            this.characteristics = response.data["characteristics"];
                            this.funtions = response.data["funtions"];
                            runToastmessage("Зміни успішно внесені в базу даних");
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors);
                        runToastmessage("Виникла помилка", "error");
                    });
            },
            resetData: function () {
                if (Object.keys(this.characteristicsData).length !== 0) {
                    this.characteristics = this.characteristicsData;
                };
                if (this.functionsData != null) {
                    this.functions = this.functionsData;
                };
            },
        },
        created() {
            this.resetData();
        },
    }
</script>
<style scoped>
    #characteristicsForm {
        margin-top: 1.2em;
    }
</style>