<template>
    <div class="container mt-3">
        <h5>{{name}}</h5>
        <template v-for="(value, key) in descriptions" v-if="value !== null">
            <p class="description-title" v-if="(key !== null)">{{ trans('localization.'+key)}}</p>
            <p class="description-text">{{value}}</p>
        </template>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {

            }
        },
        props:['descriptions', 'name'],
        methods: {
        },
    }
</script>
<style scoped>
    .description-title{
        font-weight: 600;
        font-size: 1.1em;
        margin-bottom: 0;
    }
    .description-text{
        font-size: 1.1em;
    }
</style>