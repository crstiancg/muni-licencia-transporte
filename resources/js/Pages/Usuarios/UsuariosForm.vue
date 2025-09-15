<template>
    <!-- {{ form }} -->
    <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <InputLabel value="Nombre de Usuario"></InputLabel>
                <TextInput class="w-full" v-model="form.name" :loading="form.validating"
                    @change="form.validate('name')" :error="form.invalid('name')"
                    :class="form.invalid('name') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.name"></InputError>
            </div>
            <div>
                <InputLabel value="Correo Electronico"></InputLabel>
                <TextInput class="w-full" v-model="form.email" :loading="form.validating" @change="form.validate('email')"
                    :error="form.invalid('email')" :class="form.invalid('email') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.email"></InputError>
            </div>
            <div>
                <InputLabel value="Contraseña"></InputLabel>
                <TextInput class="w-full" v-model="form.password" :loading="form.validating"
                    @change="form.validate('password')" :error="form.invalid('password')"
                    :class="form.invalid('password') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.password"></InputError>
            </div>
            <div>
                <InputLabel value="Confirmar Contraseña"></InputLabel>
                <TextInput class="w-full" v-model="form.password_confirmation" :loading="form.validating"
                    @change="form.validate('password_confirmation')" :error="form.invalid('password_confirmation')"
                    :class="form.invalid('password_confirmation') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.password_confirmation"></InputError>

            </div>
            <div>
                <InputLabel value="Documento de Identidad"></InputLabel>
                <TextInput class="w-full" v-model="form.dni" :loading="form.validating"
                    @change="form.validate('dni')" :error="form.invalid('dni')"
                    :class="form.invalid('dni') ? 'mb-2' : ''"></TextInput>
                <InputError :message="form.errors.dni"></InputError>

            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
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
    form = useForm("put", "/api/usuarios/" + props.id, {
        name: null,
        email: null,
        password: null,
        dni: null,
        password_confirmation: null,
    })
} else {
    form = useForm('post', '/api/usuarios', {
        name: null,
        email: null,
        password: null,
        dni: null,
        password_confirmation: null,
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