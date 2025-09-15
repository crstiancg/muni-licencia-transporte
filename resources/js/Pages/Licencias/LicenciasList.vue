<template>
    <AppLayout title="Licencias">
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

        <div class="mr-1 sm:ml-64">
            <div class="flex justify-end">
                <PrimaryButton @click="() => { dialog = true; title = 'Crear Licencia'; editId = null; edit = false; }">
                    Registrar Nueva
                </PrimaryButton>
            </div>
        </div>
        <div class="dark:bg-slate-800 shadow-xl sm:rounded-lg mt-6">
            <div class="p-6">
                <div class="flex justify-end space-x-2">
                    <TextInput v-model="filter" type="text" placeholder="Buscar..."
                        class="border px-3 py-2 rounded w-1/6  dark:text-slate-900">
                    </TextInput>
                    <button class="px-4 py-2 bg-blue-500 text-white rounded" @click="fetchLicencias()">
                        Recargar
                    </button>
                </div>
                <!-- <div v-if="loading" class="text-center py-4">Cargando...</div> -->
                <h2 class="text-xl font-bold mb-4">Listado de Licencias</h2>

                <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-slate-700">
                        <tr>
                            <th class="px-4 py-2 text-left cursor-pointer" @click="sortBy('id')">
                                Id
                                <!-- <span v-if="pagination.sortBy === 'id'">
                                    {{ pagination.descending ? "↓" : "↑" }}
                                </span> -->
                            </th>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Ruta</th>
                            <th class="px-4 py-2 text-left">Placa</th>
                            <th class="px-4 py-2 text-left">Empresa</th>
                            <th class="px-4 py-2 text-left">Estado</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="licencia in licencias" :key="licencia.id"
                            class="border-t  hover:bg-gray-50 dark:hover:bg-slate-700">
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
                                <PrimaryButton class="dark:bg-gray-500" @click="editar(licencia.id)">
                                    Editar
                                </PrimaryButton>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <PaginationTable :pagination="pagination" @change="goToPage"></PaginationTable>
            </div>
        </div>
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
import LicenciasForm from './LicenciasForm.vue';
import { ref, watch, onMounted } from 'vue'
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
    rowsPerPage: 14,      // Filas por página
    rowsNumber: 0,        // Total de registros
});

const fetchLicencias = async () => {
    try {
        loading.value = true;
        const { page, rowsPerPage, sortBy, descending } = pagination.value;
        const order_by = descending ? `-${sortBy}` : sortBy;
        const { data } = await axios.get("/api/licencias", {
            params: { page, per_page: rowsPerPage, order_by, search: filter.value },
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
        const { data } = await axios.get(`api/licencias/${id}`)

        formLicenciaRef.value.form.setData(data)

    } catch (error) {
        console.error("Error al cargar licencia", error)
    }

}

</script>

<style lang="scss" scoped></style>