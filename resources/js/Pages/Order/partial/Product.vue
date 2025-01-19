<script setup>
import { NCard, NButton } from 'naive-ui';
import { Link } from '@inertiajs/vue3';
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
    <n-card>
        <img
            :src="product?.images[0]?.path"
            :alt="product.name"
            class="mx-auto w-3/4 rounded-full"
        />
        <div class="mt-3 text-center">
            {{ product.name }}
        </div>
        <div class="mt-1 text-center">
            <Link
                :href="
                    route('order.show.add', {
                        order: order.id,
                        product: product.id,
                    })
                "
            >
                <n-button strong secondary round>Add Cart</n-button>
            </Link>
        </div>
    </n-card>
</template>
