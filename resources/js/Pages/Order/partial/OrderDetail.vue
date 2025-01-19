<script setup>
import { NList, NListItem, NThing, NTag, NSpace } from 'naive-ui';
defineProps({
    order: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <n-list hoverable clickable>
        <n-list-item v-for="detail in order.order_details" :key="detail.id">
            <template #prefix>
                <div class="w-10">
                    <img
                        :src="detail.product?.images[0]?.path"
                        :alt="detail.product?.name"
                        class="w-10 rounded-full"
                    />
                </div>
            </template>
            <n-thing
                :title="detail.product.name"
                content-style="margin-top: 10px;"
            >
                <template #description>
                    <n-space size="small" style="margin-top: 4px">
                        <n-tag
                            :bordered="false"
                            type="info"
                            size="small"
                            v-for="additional in detail.order_detail_additionals"
                            :key="additional.id"
                        >
                            {{ additional.order_detail_additionable.name }}
                        </n-tag>
                    </n-space>
                    <div class="mt-2 text-gray-500">{{ detail.notes }}</div>
                    <div class="mt-2 text-green-600">
                        {{ detail.product.price }}
                    </div>
                </template>
            </n-thing>
        </n-list-item>
    </n-list>
</template>
