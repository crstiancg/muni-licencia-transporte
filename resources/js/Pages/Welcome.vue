<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Frontend from '@/Layouts/Frontend.vue';
import { ref } from 'vue'
import axios from 'axios';
import ActionMessages from '@/Components/ActionMessages.vue';
const licencia = ref([]);

const max = 6;


const form = ref({
    search: ""
});

const showMessage = ref(false);
const message = ref("");

async function consultar() {
    if (!form.value.search || form.value.search.trim() === "") {
        message.value = "Por favor ingresa una placa antes de buscar.";
        showMessage.value = true;
        setTimeout(() => (showMessage.value = false), 3000);
        return;
    }

    try {
        const { data } = await axios.get(`/licencias/consulta/`, { params: form.value });

        licencia.value = data;
        showMessage.value = false;
        message.value = "";
    } catch (error) {
        if (error.response && error.response.status === 404) {
            message.value = error.response.data.message || "No existe esa placa en el sistema";
            showMessage.value = true;
            licencia.value = [];
            setTimeout(() => (showMessage.value = false), 3000);
        } else {
            message.value = "Error en la consulta";
            showMessage.value = true;
            licencia.value = [];
            setTimeout(() => (showMessage.value = false), 3000);
        }
    }
}

</script>

<template>

    <Head title="Moduclo de Consulta" />
    <Frontend>
        <div class="relative px-4 pb-0 pt-0 md:pt-[70px] -mt-[150px] md:mt-0">
            <div class="flex items-center justify-center mb-6">
                <img src="https://scontent-lim1-1.xx.fbcdn.net/v/t39.30808-6/333205624_720874452879112_5253816505687950656_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeE8PMmyCGV0OT_83dJmaxWG5z3ELWVjnkHnPcQtZWOeQZ0fEzclqX4-zPm62ib9L5i40om7cERhC8g0bIhUQu12&_nc_ohc=wp1qe8NvjUoQ7kNvwGCo2rg&_nc_oc=AdnY4PWzGB1cESmS0VIL7odHvHwJuNbuowMusL9CjdA-XZTxYRJs9zebwUcD1bHVL1w&_nc_zt=23&_nc_ht=scontent-lim1-1.xx&_nc_gid=pXvTGIbysMKES3FQPToUXg&oh=00_AfaH-foBa-Y3R8sqfA0URz-KaDfDGPzZDdNSlhK7dmAJNA&oe=68CE5A06" alt="Logo Puno"
                    style="width: 120px; height: 120px; border-radius: 55%; object-fit: cover; border: 0.1em solid #00AAE9;" />
            </div>
            <h1 class="max-w-[50rem] sm:max-w-[49rem] px-3 md:px-0 xs:text-5xl md:text-6xl text-4xl font-bold text-center text-gray-50 uppercase">
                Consulta Vehicular
            </h1>
            <h2 class="max-w-[50rem] sm:max-w-[49rem]  z-10 font-extrabold text-gray-400 mt-6 text-center px-4 text-lg">
                Gerencia de Transporte y Seguridad Vial </h2>
        </div>
        <div
            class="flex relative z-[21] mx-autom mt-8 max-w-[550px] hover:scale-105 w-full shadow-lg bg-gray-300 overflow-visible rounded-full transition-transform focus-visible:ring-sky-400 focus-visible:border-sky-400">
            <input type="text" placeholder="Ingrese una placa: A4Z160" v-model="form.search" :maxlength="max"
                class="dark:text-gray-900 block w-full px-6 pl-10 py-4 pr-2 mr-px font-sans ouline-gray-200 font-normal  text-base border-none focus:ring-0 shadow-sm rounded-s-full bg-gray-300 text-dark-900 placeholder:text-gray-500">
            <button @click="consultar()"
                class="dark:text-gray-800 flex items-center px-5 py-1.5  pr-7 text-base gap-1.5 font-sans font-semibold transition-colors border-none cursor-pointer bg-gray-00 hover:bg-gray-400 text-dark-800 group  rounded-e-full rounded-t-full rounded-s-full pointer ">
                <i class="fa fa-search"></i>
                <span>Buscar</span>
            </button>
        </div>
        <div class="relative" v-if="licencia ? true : hidden">
            <div
                class="bg-gray-800 dark:text-white max-w-md mx-auto rounded-xl shadow-xl overflow-hidden md:max-w-2xl m-5 hover:shadow-4xl hover:bg-gray-950 transition-all duration-500 ease-in-out">
                <div class="justify-center ">
                    <div class="p-6" v-for="licencia in licencia" :key="licencia.id">
                        <div class="uppercase lg:text-lg text-base text-green-500 font-extrabold text-center">
                            INFORMACIÓN DE TARJETA ÚNICA DE CIRCULACIÓN
                        </div>
                        <div class="text-center">
                            <span class="lg:text-5xl text-3xl font-extrabold text-green-400">
                                {{ licencia.placa }} - {{ licencia.codigo }}
                            </span>
                        </div>
                        <p class="block mt-1 text-lg leading-tight font-medium text-white uppercase">Propietario</p>
                        <p class="mt-2 text-gray-400">{{ licencia.nombre_conductor }}</p>
                        <p class="block mt-1 text-lg leading-tight font-medium text-white uppercase">Empresa</p>
                        <p class="mt-2 text-gray-400">{{ licencia.empresa }}</p>
                        <p class="block mt-1 text-lg leading-tight font-medium text-white uppercase">Dirección</p>
                        <p class="mt-2 text-gray-400">{{ licencia.ruta }}</p>
                        <div class="flex items-center justify-center p-2 space-x-4">
                            <Link :href="route('welcome')" style="margin-right: 20px"
                                class="text-red-500 hover:text-white">
                            <div class="image">
                                <svg fill="#000000" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M7.004 23.087l7.08-7.081-7.07-7.071L8.929 7.02l7.067 7.069L23.084 7l1.912 1.913-7.089 7.093 7.075 7.077-1.912 1.913-7.074-7.073L8.917 25z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ActionMessages :on="showMessage" type="error">
            {{ message }}
        </ActionMessages>

    </Frontend>

</template>

<style scoped>
.image {
    display: flex;
    margin-left: auto;
    margin-right: auto;
    background-color: #ffffff;
    flex-shrink: 0;
    justify-content: center;
    align-items: center;
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 9999px;
    animation: animate .6s linear alternate-reverse infinite;
    transition: .6s ease;
}

.image svg {
    color: #ffffff;
    width: 1rem;
    height: 1rem;
}

@keyframes animate {
    from {
        transform: scale(1.3);
    }

    to {
        transform: scale(1.3);
    }
}

.card {
    height: 270px;
    background-color: #1E293B;
    border-radius: 8px;
    box-shadow: 0px 2px 10px #1E293B;
    border: 2px solid #1E293B;
    font-size: 16px;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Poppins', sans-serif;
}

.icon {
    margin: 0 auto;
    width: 100%;
    height: 80px;
    max-width: 80px;
    background: linear-gradient(90deg, #faa3a3 0%, #e81515 40%, rgba(0, 0, 0, 0.28) 60%);
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.8s ease;
    background-position: 0px;
    background-size: 200px;
}

.icon svg {
    fill: #3f010100;
}

.card .title {
    width: 100%;
    margin: 0px;
    text-align: center;
    margin-top: 30px;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 4px;
}

.card .text {
    width: 80%;
    margin: 0 auto;
    font-size: 13px;
    text-align: center;
    margin-top: 20px;
    color: white;
    font-weight: 200;
    letter-spacing: 2px;
    opacity: 0;
    max-height: 0;
    transition: all 0.3s ease;
}

.card:hover {
    height: 285px;
    background-color: rgb(3 7 18);
}

.card:hover .text {
    transition: all 0.3s ease;
    opacity: 1;
    max-height: 40px;
}

.card:hover .icon {
    background-position: -120px;
    transition: all 0.3s ease;
}

.card:hover .icon svg path {
    fill: url('#gradientColor');
    transition: all 0.1s ease;
}
</style>
