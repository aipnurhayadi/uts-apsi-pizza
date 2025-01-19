<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import { NCollapse, NCollapseItem, NTag } from 'naive-ui';
import OrderDetail from '@/Pages/Order/partial/OrderDetail.vue';
defineProps({
    orders: {
        type: Array,
        required: true,
    },
});

const formatTanggalIndonesia = (isoDate) => {
    if (!isoDate) return 'Tanggal tidak valid';

    try {
        const bulanIndonesia = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        const date = new Date(isoDate);
        const day = date.getDate();
        const month = bulanIndonesia[date.getMonth()];
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');

        return `${day} ${month} ${year}, ${hours}:${minutes}`;
    } catch (error) {
        return 'Tanggal tidak valid';
    }
};
</script>
<template>
    <Head title="Transaction" />
    <CommonLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Transaction
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg"
                >
                    <div class="mx-auto w-3/4">
                        <n-collapse>
                            <n-collapse-item
                                :title="`Order Tanggal ${formatTanggalIndonesia(order.created_at)}`"
                                :name="order.id"
                                v-for="order in orders"
                                :key="order.id"
                            >
                                <template #header-extra>
                                    <div class="text-gray-400">
                                        Silakan ditunggu
                                    </div>
                                    <n-tag
                                        :type="
                                            order.order_status == 'onprogress'
                                                ? 'warning'
                                                : 'success'
                                        "
                                        class="ml-3"
                                        round
                                    >
                                        {{
                                            order.order_status == 'onprogress'
                                                ? 'On Progress'
                                                : 'Completed'
                                        }}
                                    </n-tag>
                                </template>

                                <order-detail :order="order" />
                            </n-collapse-item>
                        </n-collapse>
                    </div>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
