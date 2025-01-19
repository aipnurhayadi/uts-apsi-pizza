<script setup>
import CommonLayout from '@/Layouts/CommonLayout.vue';
defineProps({
    order: {
        type: Object,
        required: true,
    },
});
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
                    asdada
                </div>
            </div>
        </div>
    </CommonLayout>
</template>
