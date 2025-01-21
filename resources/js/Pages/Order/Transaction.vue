<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import { NCollapse, NCollapseItem, NTag, NCard, NButton, useDialog, useMessage } from 'naive-ui';
import OrderDetail from '@/Pages/Order/partial/OrderDetail.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
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

const dialog = useDialog();
const message = useMessage();

const isCancelling = ref(false);

const cancelOrder = async (orderId) => {

    dialog.warning({
        title: 'Confirm',
        content: 'Are you sure?',
        positiveText: 'Sure',
        negativeText: 'Not Sure',
        draggable: true,
        onPositiveClick: async () => {
            isCancelling.value = true;
            await router.delete(
                route('order.show.delete', { order: orderId }),
                {},
                {
                    onError: (errors) => {
                        message.error(errors.summary);
                    },
                    onFinish: () => {
                        router.reload()
                    }
                },
            );
            isCancelling.value = false;
        },
    });
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
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                    <div class="mx-auto w-3/4">
                        <span v-if="orders.length > 0">
                            <n-collapse>
                                <n-collapse-item :title="`Order Tanggal ${formatTanggalIndonesia(order.created_at)}`"
                                    :name="order.id" v-for="order in orders" :key="order.id">
                                    <template #header-extra>
                                        <div class="text-gray-400">
                                            Silakan ditunggu
                                        </div>
                                        <n-tag :type="order.order_status == 'onprogress'
                                            ? 'warning'
                                            : 'success'
                                            " class="ml-3" round>
                                            {{
                                                order.order_status == 'onprogress'
                                                    ? 'On Progress'
                                                    : 'Completed'
                                            }}
                                        </n-tag>
                                    </template>

                                    <n-card>
                                        <order-detail :order="order" />

                                        <div class="text-center"><n-button round strong secondary type="error"
                                                class="mt-4" @click="cancelOrder(order.id)"
                                                :loading="isCancelling">Cancel</n-button></div>
                                    </n-card>
                                </n-collapse-item>
                            </n-collapse>
                        </span>
                        <span v-else>
                            <div class="text-center">Belum ada transaksi</div>
                        </span>

                    </div>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
