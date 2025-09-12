<template>
    {{ form }}
     <form @submit.prevent="submit">
         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
             <div >
                 <InputLabel value="Nombre del propietario"></InputLabel>
                 <TextInput class="w-full" v-model="form.nombre_conductor"></TextInput>
             </div>
             <div>
                 <InputLabel value="Dirección"></InputLabel>
                 <TextInput class="w-full" v-model="form.ruta"></TextInput>
             </div>
             <div>
                 <InputLabel value="Placa del vehiculo"></InputLabel>
                 <TextInput class="w-full" v-model="form.placa"></TextInput>
             </div>
             <div>
                 <InputLabel value="Nombre de la empresa"></InputLabel>
                 <TextInput class="w-full" v-model="form.empresa"></TextInput>
             </div>
             <div>
                 <InputLabel value="Codigo de empresa"></InputLabel>
                 <TextInput class="w-full" v-model="form.codigo"></TextInput>
             </div>
         </div>
     </form>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
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
if(props.edit){
form = useForm("put", "/licencias/" + props.id, {
    nombre_conductor: null,
    ruta: null,
    placa: null,
    empresa: null, 
    codigo: null
})
}else {
form = useForm('post', '/licencias', {
    nombre_conductor: null,
    ruta: null,
    placa: null,
    empresa: null,
    codigo: null
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