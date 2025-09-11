<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const dialog = ref(false);
const hola = ref("holaaaa")
const close = ref(false);
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <PrimaryButton @click="() => { dialog = true }"> Registrar Nueva</PrimaryButton>

        <DialogModal max-width="4xl" :show="dialog" :closeable="false" @close="dialog = false">
            <template #title>Expediente</template>
            <template #content>
                <InputLabel value="Nombre"></InputLabel>
                <TextInput v-model="hola"></TextInput>
            </template>
            <template #footer>
                <PrimaryButton @click="() => { dialog = false }">
                    Cerrar
                </PrimaryButton>
            </template>
        </DialogModal>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                    <!-- <Welcome /> -->


                </div>
            </div>
        </div>
    </AppLayout>
</template>
