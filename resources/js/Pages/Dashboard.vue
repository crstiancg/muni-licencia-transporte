<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    data: Array
})

</script>

<template>
    <AppLayout title="Dashboard">
        <!-- <Welcome></Welcome> -->

        <!-- <pre>{{ data }}</pre> -->

        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-100">Total de Vehiculos Autorizados</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ data.total_vehiculos_autorizados }}
                </p>
            </div>
            <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-100">Total de Vehiculos Sin Autorización
                </p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{
                    data.total_vehiculos_no_autorizados }}</p>
            </div>
            <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-100">Total de Vehiculos Registrados</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ data.total }}</p>
            </div>
            <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-100">Total de Vehiculos Hoy</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ data.total_registrados_hoy }}</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <div class="col-span-3">
                <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                    <p class="text-xl font-semibold text-gray-900 uppercase dark:text-gray-100">
                        Vehiculos Registrados Recientemente
                    </p>
                    <ul class="divide-y divide-gray-200">
                        <li v-for="licencia in data.total_vehiculos_recientes" :key="licencia.id"
                            class="py-3 flex justify-between items-center">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-200">
                                    <!-- {{ licencia }} -->
                                    {{ licencia.empresa }}
                                </p>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ licencia.nombre_conductor }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-100">
                                    {{ licencia.placa }} - {{ licencia.codigo }} - {{ licencia.ruta }}
                                    <!-- S/. {{ expediente.total }} -->
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm dark:text-gray-100">
                                    {{ licencia.fecha_humana }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div >
                <div class="space-y-4">
                    <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Empresas con Mayor Cantidad de
                            Vehiculos Autorizados</p>
                        <ul class="divide-y divide-gray-200">
                            <li v-for="empresa in data.empresa" :key="empresa.id"
                                class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        {{ empresa.empresa }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm dark:text-gray-100">
                                        {{ empresa.total }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <!-- <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ data.empresa }}</p> -->

                    </div>
                    <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Empresas con Mayor Cantidad de
                            Vehiculos Sin Autorización</p>

                            <ul class="divide-y divide-gray-200">
                            <li v-for="empresa in data.empresa_no" :key="empresa.id"
                                class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-200">
                                        {{ empresa.empresa }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm dark:text-gray-100">
                                        {{ empresa.total }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="px-4 py-6 bg-gray-50 dark:bg-gray-800 sm:px-6 shadow sm:rounded-md">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Acciones Rapidas</p>

                    </div> -->
                </div>
            </div>
        </div>

    </AppLayout>
</template>
