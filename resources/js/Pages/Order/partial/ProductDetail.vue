<script setup>
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
    <img
        :src="product?.images[0]?.path"
        :alt="product.name"
        class="mx-auto w-3/4 rounded-full"
    />
    <div class="fw-bold mt-3 text-center">
        {{ product.name }}
    </div>
    <div class="mt-1 text-center">
        {{ product.idr_price }}
    </div>
    <div class="mt-1 text-center">
        {{ product.description }}
    </div>
</template>
