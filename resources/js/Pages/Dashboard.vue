<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { onMounted, ref, watch } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import LicenciasForm from './Licencias/LicenciasForm.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios'
import PaginationTable from '@/Components/PaginationTable.vue';

const dialog = ref(false);
const title = ref("");
const edit = ref(false);
const editId = ref();
const formLicenciaRef = ref()
const save = () => {
    dialog.value = false;
    console.log("Guardado con existo");
    fetchLicencias();
}


const licencias = ref([]); // Datos de la tabla
const loading = ref(false);
const filter = ref("");
const pagination = ref({
    sortBy: "id",         // Campo de orden
    descending: true,    // Orden asc/desc
    page: 1,              // Página actual
    rowsPerPage: 11,      // Filas por página
    rowsNumber: 0,        // Total de registros
});

const fetchLicencias = async () => {
    try {
        loading.value = true;

        const { page, rowsPerPage, sortBy, descending } = pagination.value;

        const order_by = descending ? `-${sortBy}` : sortBy;

        const { data } = await axios.get("/licencias", {
            params: {
                page,
                per_page: rowsPerPage,
                order_by,
                search: filter.value
            },
        });
        licencias.value = data.data;
        pagination.value.rowsNumber = data.total;
        pagination.value.page = data.current_page;
        pagination.value.rowsPerPage = data.per_page;
    } catch (error) {
        console.error("Error cargando licencias:", error);
    } finally {
        loading.value = false;
    }
};

const goToPage = (page) => {
    pagination.value.page = page;
    fetchLicencias();
};

let searchTimeout;
watch(filter, (newVal) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        pagination.value.page = 1;
        fetchLicencias();
    }, 100);
});


onMounted(() => {
    fetchLicencias();
});


async function editar(id) {
    dialog.value = true;
    edit.value = true;
    editId.value = id;
    title.value = "Editar Licencia";
    try {
        const { data } = await axios.get(`/licencias/${id}`)

        formLicenciaRef.value.form.setData(data)

    } catch (error) {
        console.error("Error al cargar licencia", error)
    }

}
</script>

<template>
    <AppLayout title="Dashboard">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->
        <DialogModal max-width="4xl" :show="dialog" :closeable="false" @close="dialog = false">
            <template #title>{{ title }}</template>
            <template #content>
                <LicenciasForm :edit="edit" :id="editId" ref="formLicenciaRef" @save="save"></LicenciasForm>
            </template>
            <template #footer>
                <SecondaryButton @click="() => { dialog = false }">
                    Cerrar
                </SecondaryButton>
                <PrimaryButton :disabled="formLicenciaRef?.form.processing" class="ml-2"
                    @click="formLicenciaRef.submit()">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-3">
                <div class="mr-1 sm:ml-64">
                    <div class="mt-16 flex justify-end">
                        <PrimaryButton @click="() => { dialog = true; title = 'Crear Licencia'; }">
                            Registrar Nueva
                        </PrimaryButton>
                    </div>
                </div>
                <div class="bg-red overflow-hidden shadow-xl sm:rounded-lg ">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-4">Listado de Licencias</h2>

                        <!-- <div v-if="loading" class="text-center py-4">Cargando...</div> -->
                        <TextInput v-model="filter" type="text" placeholder="Buscar..."
                            class="border px-3 py-2 rounded w-1/3">
                        </TextInput>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded" @click="fetchLicencias()">
                            Recargar
                        </button>
                        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left cursor-pointer" @click="sortBy('id')">
                                        ID
                                        <span v-if="pagination.sortBy === 'id'">
                                            {{ pagination.descending ? "↓" : "↑" }}
                                        </span>
                                    </th>
                                    <th class="px-4 py-2 text-left">Nombre</th>
                                    <th class="px-4 py-2 text-left">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="licencia in licencias" :key="licencia.id" class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ licencia.id }}</td>
                                    <td class="px-4 py-2">{{ licencia.nombre_conductor }}</td>
                                    <td class="px-4 py-2">{{ licencia.ruta }}</td>
                                    <td class="px-4 py-2">{{ licencia.placa }}</td>
                                    <td class="px-4 py-2">{{ licencia.empresa }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded text-sm font-semibold" :class="licencia.estado === 'no_autorizado'
                                            ? 'bg-red-100 text-red-600'
                                            : 'bg-green-100 text-green-600'">
                                            {{ licencia.estado === 'no_autorizado' ? 'No Autorizado' : 'Autorizado' }}
                                        </span>
                                    </td>
                                    <td>
                                        <PrimaryButton @click="editar(licencia.id)">
                                            Editar
                                        </PrimaryButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <PaginationTable :pagination="pagination" @change="goToPage"></PaginationTable>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
