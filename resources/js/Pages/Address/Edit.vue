<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import OSM from '@/components/Maps/OSM.vue';
import { reactive, ref } from 'vue';
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

const props = defineProps({
    address: {
        type: Object,
        required: true,
    },
    deliveryTimes: {
        type: Array,
        required: true,
    },
    outlets: {
        type: Array,
        required: true,
    },
});

const formRef = ref(null);
const loadingSubmit = ref(false);
const form = reactive({
    location: props.address?.location || '',
    description: props.address?.description || '',
    outlet: props.address?.outlet || null,
    delivery_time_id: props.address?.deliveryTimes || null,
});

const rules = {
    location: { required: true, message: 'Location is required' },
    address: { required: true, message: 'Address is required' },
    outlet_id: { required: true, message: 'Please select an outlet' },
    delivery_time_id: {
        required: true,
        message: 'Please select a delivery time',
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
                    router.put(route('address.update'), form, {
                        onError: (errors) => {
                            message.error(errors.summary);
                        },
                    });
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
    <Head title="Delivery Address" />
    <CommonLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Delivery Address
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <n-grid cols="4" item-responsive responsive="screen">
                        <n-grid-item span="4 m:1 l:1">
                            <div class="p-5">
                                <n-form
                                    :model="form"
                                    :rules="rules"
                                    ref="formRef"
                                    label-placement="top"
                                    size="medium"
                                >
                                    <n-form-item
                                        label="Location"
                                        path="location"
                                    >
                                        <n-input
                                            v-model:value="form.location"
                                            placeholder="Enter location"
                                        />
                                    </n-form-item>

                                    <n-form-item
                                        label="Address"
                                        path="description"
                                    >
                                        <n-input
                                            v-model:value="form.description"
                                            placeholder="Enter address"
                                        />
                                    </n-form-item>

                                    <n-form-item
                                        label="Outlet"
                                        path="outlet_id"
                                    >
                                        <n-select
                                            v-model:value="form.outlet_id"
                                            placeholder="Select an outlet"
                                            :options="
                                                outlets.map((outlet) => ({
                                                    label: outlet.name,
                                                    value: outlet.id,
                                                }))
                                            "
                                        />
                                    </n-form-item>

                                    <n-form-item
                                        label="Delivery Time"
                                        path="delivery_time_id"
                                    >
                                        <n-select
                                            v-model:value="
                                                form.delivery_time_id
                                            "
                                            placeholder="Select a delivery time"
                                            :options="
                                                deliveryTimes.map((time) => ({
                                                    label: time.name,
                                                    value: time.id,
                                                }))
                                            "
                                        />
                                    </n-form-item>

                                    <n-form-item>
                                        <n-button
                                            type="primary"
                                            html-type="submit"
                                            @click="handleValidateButtonClick"
                                            :loading="loadingSubmit"
                                        >
                                            Submit
                                        </n-button>
                                    </n-form-item>
                                </n-form>
                            </div>
                        </n-grid-item>
                        <n-grid-item span="4 m:3 l:3">
                            <div class="p-5">
                                <OSM />
                            </div>
                        </n-grid-item>
                    </n-grid>
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
