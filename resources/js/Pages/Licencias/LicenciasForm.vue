<template>
    <!-- {{ form }} -->
    <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <InputLabel value="Nombre del propietario"></InputLabel>
                <TextInput class="w-full" v-model="form.nombre_conductor" :loading="form.validating"
                    @change="form.validate('nombre_conductor')" :error="form.invalid('nombre_conductor')"
                    :class="form.invalid('nombre_conductor') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.nombre_conductor"></InputError>
            </div>
            <div>
                <InputLabel value="Dirección"></InputLabel>
                <TextInput class="w-full" v-model="form.ruta" :loading="form.validating" @change="form.validate('ruta')"
                    :error="form.invalid('ruta')" :class="form.invalid('ruta') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.ruta"></InputError>
            </div>
            <div>
                <InputLabel value="Placa del vehiculo"></InputLabel>
                <TextInput class="w-full" v-model="form.placa" :loading="form.validating"
                    @change="form.validate('placa')" :error="form.invalid('placa')"
                    :class="form.invalid('placa') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.placa"></InputError>
            </div>
            <div>
                <InputLabel value="Nombre de la empresa"></InputLabel>
                <TextInput class="w-full" v-model="form.empresa" :loading="form.validating"
                    @change="form.validate('empresa')" :error="form.invalid('empresa')"
                    :class="form.invalid('empresa') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.empresa"></InputError>

            </div>
            <div>
                <InputLabel value="Codigo de empresa"></InputLabel>
                <TextInput class="w-full" v-model="form.codigo" :loading="form.validating"
                    @change="form.validate('codigo')" :error="form.invalid('codigo')"
                    :class="form.invalid('codigo') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.codigo"></InputError>

            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { onMounted } from 'vue';
const emits = defineEmits(["save"]);
const props = defineProps({
    id: Number,
    edit: {
        type: Boolean,
        default: false,
    },
});

let form;
if (props.edit) {
    form = useForm("put", "/api/licencias/" + props.id, {
        nombre_conductor: null,
        ruta: null,
        placa: null,
        empresa: null,
        codigo: null,
        user_id: null,
    })
} else {
    form = useForm('post', '/api/licencias', {
        nombre_conductor: null,
        ruta: null,
        placa: null,
        empresa: null,
        codigo: null,
        user_id: null,
    })
}

const submit = () => {
    form
        .submit()
        .then((response) => {
            emits("save", response.data);
            form.reset();
            // form.setData()
        })
        .catch((error) => {
            // alert("An error occurred.");
        });
};


onMounted(() => {
    console.log(props);

})

defineExpose({ submit, form });



</script>

<style lang="scss" scoped></style>