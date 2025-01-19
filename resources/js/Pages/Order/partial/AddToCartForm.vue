<script setup>
import { router, useForm } from '@inertiajs/vue3';
import {
    NRadioButton,
    NRadioGroup,
    NButton,
    useMessage,
    useDialog,
    NForm,
    NFormItem,
    NInput,
} from 'naive-ui';
import { ref } from 'vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    order: {
        type: Object,
        required: true,
    },
});

console.log(props.product, props.order);

const form = useForm({
    crust_id: null,
    size_id: null,
    notes: '',
});

const formRef = ref(null);
const loadingSubmit = ref(false);

const rules = {
    crust_id: [
        {
            type: 'integer',
            required: true,
            message: 'Crust harus dipilih',
        },
    ],
    size_id: [
        {
            type: 'integer',
            required: true,
            message: 'Size harus dipilih',
        },
    ],
    notes: [
        {
            required: true,
            message: 'Catatan tidak boleh kosong',
        },
    ],
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
                        route('order.show.doadd', {
                            product: props.product.id,
                            order: props.order.id,
                        }),
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
    <section>
        <n-form
            :model="form"
            :rules="rules"
            ref="formRef"
            label-placement="top"
            size="medium"
        >
            <span v-if="product.sizes.length > 0">
                <n-form-item label="Crust" path="crust_id">
                    <n-radio-group
                        v-model:value="form.crust_id"
                        name="crust_id"
                    >
                        <n-radio-button
                            v-for="crust in product.crusts"
                            :key="crust.id"
                            :value="crust.id"
                            :label="crust.name"
                        />
                    </n-radio-group>
                </n-form-item>
            </span>

            <span v-if="product.sizes.length > 0">
                <n-form-item label="Size" path="size_id">
                    <n-radio-group v-model:value="form.size_id" name="size_id">
                        <n-radio-button
                            v-for="size in product.sizes"
                            :key="size.id"
                            :value="size.id"
                            :label="size.name"
                        />
                    </n-radio-group>
                </n-form-item>
            </span>

            <n-form-item label="Notes" path="notes">
                <n-input
                    type="textarea"
                    v-model:value="form.notes"
                    placeholder="Notes"
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
    </section>
</template>
