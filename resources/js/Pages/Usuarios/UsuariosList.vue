<template>
    <AppLayout title="usuarios">
    
        <DialogModal max-width="4xl" :show="dialog" :closeable="false" @close="dialog = false">
            <template #title>{{ title }}</template>
            <template #content>
                <UsuariosForm :edit="edit" :id="editId" ref="formUsuariosRef" @save="save"></UsuariosForm>
            </template>
            <template #footer>
                <SecondaryButton @click="() => { dialog = false }">
                    Cerrar
                </SecondaryButton>
                <PrimaryButton :disabled="formUsuariosRef?.form.processing" class="ml-2"
                    @click="formUsuariosRef.submit()">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <div class="mr-1 sm:ml-64">
            <div class="flex justify-end">
                <PrimaryButton @click="() => { dialog = true; title = 'Crear usuario'; editId = null; edit = false; }">
                    Registrar Nueva
                </PrimaryButton>
            </div>
        </div>
        <div class="dark:bg-slate-800 shadow-xl sm:rounded-lg mt-6 relative overflow-x-auto ">
            <div class="p-6">
                <div class="flex justify-end space-x-2">
                    <TextInput v-model="filter" type="text" placeholder="Buscar..."
                        class="border px-3 py-2 rounded w-1/6  dark:text-slate-900">
                    </TextInput>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded" @click="onRequest()">
                        Recargar
                    </button>
                </div>
                <!-- <div v-if="loading" class="text-center py-4">Cargando...</div> -->
                <h2 class="text-xl font-bold mb-4">Listado de usuarios</h2>

                <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-slate-700">
                        <tr>
                            <!-- <th class="px-4 py-2 text-left cursor-pointer" @click="sortBy('id')">
                                Id
                            </th> -->
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Correo Electronico</th>
                            <th class="px-4 py-2 text-left">N° DNI</th>
                            <th class="px-4 py-2 text-left">Estado</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="usuario in usuarios" :key="usuario.id" v-show="usuario?.id !== 1"
                            class="border-t  hover:bg-gray-50 dark:hover:bg-slate-700">
                            <!-- <td class="px-4 py-2">{{ usuario.id }}</td> -->
                            <td class="px-4 py-2">{{ usuario.name }}</td>
                            <td class="px-4 py-2">{{ usuario.email }}</td>
                            <td class="px-4 py-2">{{ usuario.dni }}</td>
                             <td class="px-4 py-2">
                                <span @click="cambiarEstado(usuario.id)"  class="px-2 py-1 rounded-lg text-sm font-semibold cursor-pointer" :class="usuario.estado === 0
                                    ? 'bg-red-100 text-red-600'
                                    : 'bg-green-100 text-green-600'">
                                    {{ usuario.estado === 0 ? 'Inactivo' : 'Activo' }}
                                </span>
                            </td>
                            <td>
                                <!-- {{ usuario.estado }} -->
                                <!-- <Checkbox class="mr-2" :checked="usuario.estado == 1 ? true: false" @click="cambiarEstado(usuario.id)"></Checkbox> Activar / Desactivar -->
                                <PrimaryButton class="dark:bg-gray-500" @click="editar(usuario.id)" >
                                    Editar
                                </PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <PaginationTable :pagination="pagination" @change="goToPage"></PaginationTable>
            </div>
        </div>
            <ActionMessages :on="showMessage" type="success">
            {{ message }}
        </ActionMessages>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios'
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PaginationTable from '@/Components/PaginationTable.vue';
import DialogModal from '@/Components/DialogModal.vue';
import UsuariosForm from './UsuariosForm.vue';
import { ref, watch, onMounted } from 'vue'
import Checkbox from '@/Components/Checkbox.vue';
import ActionMessages from '@/Components/ActionMessages.vue';
const dialog = ref(false);
const title = ref("");
const edit = ref(false);
const editId = ref();
const formUsuariosRef = ref()
const showMessage = ref(false);
const message =  ref("");
const save = () => {
    dialog.value = false;
    console.log("Guardado con existo");
    onRequest();
    showMessage.value = true;
    message.value = "Guardado con exito."
        setTimeout(() => (showMessage.value = false), 3000);
        return;

}


const usuarios = ref([]); // Datos de la tabla
const loading = ref(false);
const filter = ref("");
const pagination = ref({
    sortBy: "id",         // Campo de orden
    descending: true,    // Orden asc/desc
    page: 1,              // Página actual
    rowsPerPage: 14,      // Filas por página
    rowsNumber: 0,        // Total de registros
});

const onRequest = async () => {
    try {
        loading.value = true;
        const { page, rowsPerPage, sortBy, descending } = pagination.value;
        const order_by = descending ? `-${sortBy}` : sortBy;
        const { data } = await axios.get("/api/usuarios", {
            params: { page, per_page: rowsPerPage, order_by, search: filter.value },
        });
        usuarios.value = data.data;
        pagination.value.rowsNumber = data.total;
        pagination.value.page = data.current_page;
        pagination.value.rowsPerPage = data.per_page;
    } catch (error) {
        console.error("Error cargando usuarios:", error);
    } finally {
        loading.value = false;
    }
};

const goToPage = (page) => {
    pagination.value.page = page;
    onRequest();
};

let searchTimeout;
watch(filter, (newVal) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        pagination.value.page = 1;
        onRequest();
    }, 100);
});


onMounted(() => {
    onRequest();
});


async function editar(id) {
    dialog.value = true;
    edit.value = true;
    editId.value = id;
    title.value = "Editar Usuario";
    try {
        const { data } = await axios.get(`api/usuarios/${id}`)

        console.log(data);
        
        formUsuariosRef.value.form.setData(data)

    } catch (error) {
        console.error("Error al cargar usuarios", error)
    }

}

async function cambiarEstado(id) {
    console.log(id);
     try {
    const { data } = await axios.get(`api/usuarios/estado/${id}`)

    console.log(data);
    onRequest();

    
    } catch (error) {
        console.error("Error al cargar usuarios", error)
    }
    
    
}

</script>

<style lang="scss" scoped></style>