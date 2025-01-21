<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import OrderDetail from '@/Pages/Order/partial/OrderDetail.vue';
import { router } from '@inertiajs/vue3';
import {
    useMessage,
    useDialog,
    NForm,
    NFormItem,
    NInput,
    NSelect,
    NButton,
    NGrid,
    NGridItem,
} from 'naive-ui';
import { reactive, ref } from 'vue';
const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    address: {
        type: Object,
        required: true,
    },
    paymentMethods: {
        type: Array,
        required: true,
    },
});

console.log(props.paymentMethods);

const formRef = ref(null);
const loadingSubmit = ref(false);
const form = reactive({
    payment_method_id: null,
});

const rules = {
    payment_method_id: {
        required: true,
        message: 'Payment Method is required',
    },
};

const dialog = useDialog();
const message = useMessage();

const handleValidateButtonClick = () => {
    formRef.value?.validate((errors) => {
        if (!errors) {
            dialog.warning({
                title: 'Confirm',
                content: 'Are you sure?',
                positiveText: 'Sure',
                negativeText: 'Not Sure',
                draggable: true,
                onPositiveClick: () => {
                    router.post(
                        route('order.show.docart', { order: props.order.id }),
                        form,
                        {
                            onError: (errors) => {
                                message.error(errors.summary);
                            },
                        },
                    );
                },
            });
        } else {
            console.log(errors);
            message.error('Invalid');
        }
    });
};
</script>
<template>

    <Head title="Cart" />
    <CommonLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Cart
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                    <n-grid cols="4" item-responsive responsive="screen">
                        <n-grid-item span="4 m:1 l:1">
                            <div class="p-5">
                                <n-form>
                                    <n-form-item label="Order Type">
                                        <n-input :value="order.order_type" disabled />
                                    </n-form-item>
                                    <n-form-item label="Delivery Schedule">
                                        <n-input :value="address.delivery_time.name" disabled />
                                    </n-form-item>
                                    <n-form-item label="Outlet">
                                        <n-input :value="address.outlet.name" disabled />
                                    </n-form-item>
                                    <n-form-item label="Delivery Address">
                                        <n-input :value="address.description" disabled />
                                    </n-form-item>
                                </n-form>
                            </div>
                        </n-grid-item>
                        <n-grid-item span="4 m:3 l:3">
                            <div class="p-5">
                                <n-form :model="form" :rules="rules" ref="formRef" label-placement="top" size="medium">
                                    <n-form-item label="Payment Method" path="payment_method_id">
                                        <n-select v-model:value="form.payment_method_id
                                            " placeholder="Select a payment method" :options="paymentMethods.map(
                                                (payment) => ({
                                                    label: payment.name,
                                                    value: payment.id,
                                                }),
                                            )
                                                " />
                                    </n-form-item>

                                    <order-detail :order="order" />

                                    <div class="text-center mt-4">
                                        <n-button round secondary type="primary" html-type="submit"
                                            @click="handleValidateButtonClick" :loading="loadingSubmit">
                                            Checkout
                                        </n-button>
                                    </div>
                                </n-form>
                            </div>
                        </n-grid-item>
                    </n-grid>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
