<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import ProductDetail from '@/Pages/Order/partial/ProductDetail.vue';
import AddToCartForm from '@/Pages/Order/partial/AddToCartForm.vue';
import { NGrid, NGridItem } from 'naive-ui';
defineProps({
    product: {
        type: Object,
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
                {{ product.name }}
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg"
                >
                    <n-grid cols="4" item-responsive responsive="screen">
                        <n-grid-item span="4 m:1 l:1">
                            <product-detail :product="product" :order="order" />
                        </n-grid-item>
                        <n-grid-item span="4 m:3 l:3">
                            <div class="p-5">
                                <add-to-cart-form
                                    :product="product"
                                    :order="order"
                                />
                            </div>
                        </n-grid-item>
                    </n-grid>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
