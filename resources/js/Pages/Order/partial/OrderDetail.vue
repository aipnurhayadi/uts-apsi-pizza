<script setup>
import { NList, NListItem, NThing, NTag, NSpace } from 'naive-ui';
import {
    calculateOrderTotal,
    calculateByOrderDetailId
} from '../../../orderCalc'
const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
});

const orderDetailsWithTotal = props.order.order_details.map((detail) => {
    const calculated = calculateByOrderDetailId(props.order, detail.id);
    return {
        ...detail,
        total: calculated.total, // Menyimpan total yang dihitung
    };
});
const calculateOrder = calculateOrderTotal(props.order)
</script>
<template>
    <n-list hoverable clickable>
        <n-list-item v-for="detail in orderDetailsWithTotal" :key="detail.id">
            <template #prefix>
                <div class="w-10">
                    <img :src="detail.product?.images[0]?.path" :alt="detail.product?.name" class="w-10 rounded-full" />
                </div>
            </template>

            <n-thing :title="detail.product.name" content-style="margin-top: 10px;">
                <template #description>
                    <n-space size="small" style="margin-top: 4px">
                        <n-tag :bordered="false" type="info" size="small"
                            v-for="additional in detail.order_detail_additionals" :key="additional.id">
                            {{ additional.order_detail_additionable.name }}
                        </n-tag>
                    </n-space>
                    <div class="mt-2 text-gray-500">{{ detail.notes }}</div>
                    <div class="mt-2 text-xs text-gray-800 font-bold">
                        {{ detail.product.price }}
                    </div>
                </template>
            </n-thing>

            <template #suffix>
                <div class="mt-2 text-xs text-green-600 font-bold min-w-32 text-right">
                    Rp {{ detail.total.toLocaleString('id-ID', { minimumFractionDigits: 2 }) }}
                </div>
            </template>
        </n-list-item>
    </n-list>

    <hr />
    <div class="mt-3 text-right text-lg text-green-600 font-bold">{{ ` Rp
        ${calculateOrder.grandTotal.toLocaleString('id-ID',
        {
            minimumFractionDigits: 2
        })}`
        }}
    </div>
</template>
