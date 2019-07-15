<template>
    <a href="#" data-toggle="modal" data-target="#cartModal">
        <i class="fas fa-shopping-cart"></i>
        <span class='badge badge-warning' id='lblCartCount'>{{totalQty}}</span>
    </a>
</template>
<script>
    export default {
        computed: {
            totalQty () {
                return this.$store.getters.getTotalQty
            },
        },
    }
</script>

<style scoped>

</style>