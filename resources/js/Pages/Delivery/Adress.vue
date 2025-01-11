<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    delivery_adresses: {
        type: [Array],
        required: true,
    },
});
console.log(props.delivery_adresses)
</script>
<template>

    <Head title="Delivery Adress" />
    <CommonLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Delivery Adress
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-5 shadow-sm sm:rounded-lg">
                    delivery adress
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
