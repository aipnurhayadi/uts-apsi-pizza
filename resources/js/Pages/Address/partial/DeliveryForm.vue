<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    delivery_times: {
        type: [Array],
        required: true,
    },
    outlets: {
        type: [Array],
        required: true,
    },
});

const user = usePage().props.auth.user;
console.log(user);

const form = useForm({
    location: '',
    address: '',
    longitude: '',
    latitude: '',
    outlet_id: '',
    delivery_time_id: '',
});
</script>

<template>
    <section>
        <form class="mt-6 space-y-6">
            <div>
                <InputLabel for="location" value="Lokasi" />

                <TextInput
                    id="location"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.location"
                    required
                    autofocus
                    autocomplete="location"
                />

                <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div>
                <InputLabel for="address" value="Alamat" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    required
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="address" value="Alamat" />

                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    required
                    autofocus
                    autocomplete="address"
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>
        </form>
    </section>
</template>
