<template>
    <div class="container">
        <div class="row">
            <div class="characteristic-title col-12">{{ trans('localization.mechanism')}}</div>

            <template v-if="clockData.characteristics.кharakterystykaMekhanizmu !== null">
                <div class="characteristic-key col-6">{{ trans('localization.кharakterystykaMekhanizmu')}}</div>
                <div class="characteristic-value col-6">{{clockData.characteristics.кharakterystykaMekhanizmu}}</div>
            </template>

            <template v-if="clockData.type_of_mechanism !== null">
                <div class="characteristic-key col-6">{{ trans('localization.typeOfMechanism')}}</div>
                <div class="characteristic-value col-6">{{ trans('localization.' + clockData.type_of_mechanism)}}</div>
            </template>
        </div>
        <div class="row">
            <div class="characteristic-title col-12 border-top">{{ trans('localization.body')}}</div>

            <template v-if="clockData.characteristics.bodyMaterial !== null">
                <div class="characteristic-key col-6">{{ trans('localization.bodyMaterial')}}</div>
                <div class="characteristic-value col-6">{{trans('localization.' + clockData.characteristics.bodyMaterial)}}</div>
            </template>

            <template v-if="clockData.characteristics.glass !== null">
                <div class="characteristic-key col-6">{{ trans('localization.glass')}}</div>
                <div class="characteristic-value col-6">{{trans('localization.' + clockData.characteristics.glass)}}</div>
            </template>

            <template v-if="clockData.characteristics.style !== null">
                <div class="characteristic-key col-6">{{ trans('localization.style')}}</div>
                <div class="characteristic-value col-6">{{trans('localization.' + clockData.characteristics.style)}}</div>
            </template>
        </div>
        <div class="row">
            <div class="characteristic-title col-12 border-top">{{ trans('localization.strap')}}</div>

            <template v-if="clockData.characteristics.strapMaterial !== null">
                <div class="characteristic-key col-6">{{ trans('localization.strapMaterial')}}</div>
                <div class="characteristic-value col-6">{{trans('localization.' + clockData.characteristics.strapMaterial)}}</div>
            </template>
        </div>
        <div class="row">
            <div class="characteristic-title col-12 border-top">{{ trans('localization.dimensions')}}</div>

            <template v-if="clockData.characteristics.strapMaterial !== null">
                <div class="characteristic-key col-6">{{ trans('localization.diametr')}}</div>
                <div class="characteristic-value col-6">{{clockData.characteristics.diametr}} мм</div>
            </template>
            <template v-if="clockData.characteristics.strapMaterial !== null">
                <div class="characteristic-key col-6">{{ trans('localization.tovshchyna')}}</div>
                <div class="characteristic-value col-6">{{clockData.characteristics.tovshchyna}} мм</div>
            </template>
        </div>


    </div>
</template>

<script>
    export default {
        data: function () {
            return {

            }
        },
        props:['clockData'],
        methods: {
        },
    }
</script>
<style scoped>
    .characteristic-title{
        font-weight: 600;
        font-size: 1.2em;
        margin-bottom: 0.5em;
        margin-top: 1em;
        color: #e62633;
    }
    .characteristic-key{
        font-size: 1em;
        font-weight: 600;
    }
    .characteristic-value{
        font-size: 1em;
    }
</style>