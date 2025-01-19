<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import Product from '@/Pages/Order/partial/Product.vue';
import CartIcon from '@/Components/Icons/CartIcon.vue';
import { NGrid, NGridItem, NButton } from 'naive-ui';
import { Link } from '@inertiajs/vue3'
defineProps({
    products: {
        type: Array,
        required: true,
    },
    order: {
        type: Object,
        required: true,
    },
});
</script>
<template>

    <Head title="Shop" />
    <CommonLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Shop
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                    <n-grid cols="4" item-responsive responsive="screen">
                        <n-grid-item span="4 m:2 l:1" v-for="(product, idx) in products" :key="idx">
                            <div class="m-1">
                                <product :product="product" :order="order" />
                            </div>
                        </n-grid-item>
                    </n-grid>
                </div>
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg mt-5 text-center">

                    <Link :href="route('order.show.cart', { order: order.id })">
                    <n-button size="large" strong secondary round type="primary">
                        <CartIcon /> &nbsp; Cart
                    </n-button>
                    </Link>
                </div>
            </div>

        </div>
    </CommonLayout>
</template>
