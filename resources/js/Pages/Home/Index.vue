<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import DeliveryIcon from '@/Components/Icons/DeliveryIcon.vue';
import TakeAwayIcon from '@/Components/Icons/TakeAwayIcon.vue';
import { Head, Link } from '@inertiajs/vue3';
import { NGrid, NGi, NTabs, NTabPane, NH3, NButton } from 'naive-ui';
import { ref, watch } from 'vue';

const props = defineProps({
    products: {
        type: [Array],
        required: true,
    },
});

const productTabActive = ref(`product-${props.products[0]?.id}`);
const productTabActiveData = ref(props.products[0]);

watch(productTabActive, () => {
    productTabActiveData.value =
        props.products.find(
            (r) => `product-${r.id}` == productTabActive.value,
        ) ?? {};
});
</script>
<template>
    <Head title="Home" />
    <CommonLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Home
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg"
                >
                    <n-grid
                        x-gap="24"
                        :cols="12"
                        class="flex h-full items-center justify-center"
                    >
                        <n-gi :span="8">
                            <div class="mb-5">
                                <Link :href="route('address.edit')">
                                    <n-button
                                        strong
                                        secondary
                                        round
                                        type="primary"
                                        class="me-5"
                                    >
                                        <DeliveryIcon /> &nbsp; Delivery
                                    </n-button>
                                </Link>

                                <n-button
                                    strong
                                    secondary
                                    round
                                    type="primary"
                                    disabled
                                >
                                    <TakeAwayIcon /> &nbsp; Take Away
                                </n-button>
                            </div>
                            <span v-if="props.products">
                                <n-tabs
                                    placement="bottom"
                                    justify-content="start"
                                    animated
                                    class="w-100"
                                    v-model:value="productTabActive"
                                >
                                    <n-tab-pane
                                        v-for="(
                                            product, product_idx
                                        ) in props.products"
                                        :key="product_idx"
                                        :name="`product-${product.id}`"
                                    >
                                        <template #tab>
                                            <img
                                                :src="product?.images[0]?.path"
                                                :alt="product.name"
                                                class="my-3 h-20 w-20 rounded-full"
                                            />
                                        </template>

                                        <n-h3 class="my-1">{{
                                            product.name
                                        }}</n-h3>
                                        {{ product.description }}
                                    </n-tab-pane>
                                </n-tabs>
                            </span>
                            <span v-else>
                                <i class="text-center text-gray-400"
                                    >Belum ada produk</i
                                >
                            </span>
                        </n-gi>

                        <n-gi :span="4">
                            <img
                                :src="productTabActiveData?.images[0]?.path"
                                :alt="productTabActiveData?.name"
                                class="w-100 s rounded-full"
                            />
                        </n-gi>
                    </n-grid>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
