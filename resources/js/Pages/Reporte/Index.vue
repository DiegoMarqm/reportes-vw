<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    reporte: {
        type: Object,
        required: true
    }
});

// PAginate
const currentPage = ref(1);
const pageSize = ref(2);

const paginatedReportes = computed(() => {
    const start = (currentPage.value - 1) * pageSize.value;
    const end = start + pageSize.value;
    return filteredReportes.value.slice(start, end);
});


const totalPages = computed(() => Math.ceil(filteredReportes.value.length / pageSize.value));

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

const searchQuery = ref('');
const advancedSearch = ref(false);
const departamento = ref('');
const calificacion = ref('');
const estado = ref('');
const procedeQueja = ref('');
const fechaSeleccionada = ref('');
const fechaEspecifica = ref('');
const isSearching = ref(false);
const noHayReportes = ref(false);

const toggleAdvancedSearch = () => {
    advancedSearch.value = !advancedSearch.value;
    if (!advancedSearch.value) limpiarFiltros();
};

const buscarReportes = () => applyFilters();

const limpiarFiltros = () => {
    searchQuery.value = '';
    departamento.value = '';
    calificacion.value = '';
    estado.value = '';
    procedeQueja.value = '';
    fechaSeleccionada.value = '';
    fechaEspecifica.value = '';
    applyFilters();
};

// const filteredReportes = ref([...props.reporte].sort((a, b) => new Date(b.fechaQueja) - new Date(a.fechaQueja)));
const filteredReportes = ref([...props.reporte]);

const applyFilters = () => {
    filteredReportes.value = props.reporte.filter(infoReporte => {
        if (!advancedSearch.value) {
            // console.log(filteredReportes.value)
            return !searchQuery.value || infoReporte.numFolio.toString().toLowerCase().includes(searchQuery.value.toLowerCase());
        } else {
            const cumpleDepartamento = !departamento.value || infoReporte.departamento.toLowerCase().includes(departamento.value.toLowerCase());
            const cumpleCalificacion = !calificacion.value || infoReporte.calificacion.toString().includes(calificacion.value);
            const cumpleEstado = !estado.value || ((infoReporte.estado ? 'activo' : 'finalizado') === estado.value);
            const cumpleProcedeQueja = !procedeQueja.value || ((infoReporte.procedeQueja ? 'si' : 'no') === procedeQueja.value);
            const cumpleFecha = checkFechaQueja(infoReporte.fechaQueja);

            // console.log(filteredReportes.value)

            return cumpleDepartamento && cumpleCalificacion && cumpleEstado && cumpleProcedeQueja && cumpleFecha;


        }

    });

    noHayReportes.value = filteredReportes.value.length === 0;

    // Sino hay filtros mostrar todo los registros
    if (!searchQuery.value && !departamento.value && !calificacion.value && !estado.value && !procedeQueja.value && !fechaSeleccionada.value && !fechaEspecifica.value) {
        filteredReportes.value = props.reporte;
    }

};



const checkFechaQueja = (fechaQueja) => {
    const fecha = new Date(fechaQueja + 'T00:00:00Z'); // Formato "YYYY-MM-DD" tratado como UTC
    const hoy = new Date();
    let inicioRango = null;
    let finRango = new Date(Date.UTC(hoy.getUTCFullYear(), hoy.getUTCMonth(), hoy.getUTCDate(), 23, 59, 59, 999));

    if (fechaEspecifica.value) {
        const [year, month] = fechaEspecifica.value.split('-');
        inicioRango = new Date(Date.UTC(year, month - 1, 1, 0, 0, 0, 0));
        finRango = new Date(Date.UTC(year, month, 0, 23, 59, 59, 999));
    }

    if (fechaSeleccionada.value && inicioRango) {
        const ajusteInicio = new Date(inicioRango);
        switch (fechaSeleccionada.value) {
            case '3_meses':
                ajusteInicio.setUTCMonth(ajusteInicio.getUTCMonth() - 2);
                // Ajustar al primer día del mes de inicio
                inicioRango = new Date(Date.UTC(ajusteInicio.getUTCFullYear(), ajusteInicio.getUTCMonth(), 1, 0, 0, 0, 0));
                break;
            case '6_meses':
                ajusteInicio.setUTCMonth(ajusteInicio.getUTCMonth() - 5);
                inicioRango = new Date(Date.UTC(ajusteInicio.getUTCFullYear(), ajusteInicio.getUTCMonth(), 1, 0, 0, 0, 0));
                break;
            case '1_año':
                ajusteInicio.setUTCFullYear(ajusteInicio.getUTCFullYear() - 1);
                inicioRango = new Date(Date.UTC(ajusteInicio.getUTCFullYear(), ajusteInicio.getUTCMonth(), 1, 0, 0, 0, 0));
                break;
            default:
                break;
        }
    }

    return inicioRango ? fecha >= inicioRango && fecha <= finRango : fecha <= finRango;
};




watch([searchQuery, advancedSearch, departamento, calificacion, estado, procedeQueja, fechaSeleccionada, fechaEspecifica], async () => {
    isSearching.value = true;
    await new Promise(resolve => setTimeout(resolve, 300));
    applyFilters();
    isSearching.value = false;
});

defineExpose({ filteredReportes });

</script>


<template>
    <div class="min-h-screen bg-vw-light-grey">

        <Head title="Reportes" />
        <AuthenticatedLayout>
            <div class="pl-6 pr-6">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="mb-6">
                                <div class="relative">
                                    <input v-if="!advancedSearch" v-model="searchQuery" type="text"
                                        placeholder="Buscar por número de folio..."
                                        class="w-full px-4 py-3 border border-vw-tin-grey rounded-lg text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-300 font-vwtext" />
                                    <button @click="toggleAdvancedSearch"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-vw-tin-grey hover:text-vw-dark-blue transition duration-300">
                                        <svg v-if="!advancedSearch" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <transition enter-active-class="transition ease-out duration-300"
                                enter-from-class="opacity-0 transform scale-95 -translate-y-2"
                                enter-to-class="opacity-100 transform scale-100 translate-y-0"
                                leave-active-class="transition ease-in duration-200"
                                leave-from-class="opacity-100 transform scale-100 translate-y-0"
                                leave-to-class="opacity-0 transform scale-95 -translate-y-2">
                                <div v-if="advancedSearch" class="bg-white rounded-lg shadow-lg p-6 mb-6 mt-4">
                                    <h3 class="text-lg font-semibold text-vw-dark-blue mb-4">Búsqueda Avanzada</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-vw-dark-blue"
                                                for="departamento">
                                                Departamento
                                            </label>
                                            <select v-model="departamento" id="departamento"
                                                class="w-full px-4 py-2 border border-vw-tin-grey rounded-md text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-150 ease-in-out">
                                                <option value="">Selecciona</option>
                                                <option value="Ventas">Ventas</option>
                                                <option value="Seminuevos">Seminuevos</option>
                                                <option value="Servicio">Servicio</option>
                                                <option value="Refacciones">Refacciones</option>
                                            </select>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-vw-dark-blue"
                                                for="calificacion">
                                                Calificación
                                            </label>
                                            <select v-model="calificacion" id="calificacion"
                                                class="w-full px-4 py-2 border border-vw-tin-grey rounded-md text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-150 ease-in-out">
                                                <option value="">Selecciona</option>
                                                <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                                            </select>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-vw-dark-blue" for="estado">
                                                Estado
                                            </label>
                                            <select v-model="estado" id="estado"
                                                class="w-full px-4 py-2 border border-vw-tin-grey rounded-md text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-150 ease-in-out">
                                                <option value="">Selecciona estado</option>
                                                <option value="activo">Activo</option>
                                                <option value="finalizado">Finalizado</option>
                                            </select>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-vw-dark-blue"
                                                for="procedeQueja">
                                                ¿Procede Queja?
                                            </label>
                                            <select v-model="procedeQueja" id="procedeQueja"
                                                class="w-full px-4 py-2 border border-vw-tin-grey rounded-md text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-150 ease-in-out">
                                                <option value="">Selecciona</option>
                                                <option value="si">Sí</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-vw-dark-blue"
                                                for="fechaEspecifica">
                                                Fecha específica
                                            </label>
                                            <input type="month" v-model="fechaEspecifica" id="fechaEspecifica"
                                                class="w-full px-4 py-2 border border-vw-tin-grey rounded-md text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-150 ease-in-out" />
                                        </div>

                                        <div v-if="fechaEspecifica" class="space-y-2">
                                            <label class="block text-sm font-medium text-vw-dark-blue"
                                                for="fechaSeleccionada">
                                                Rango de Fecha de Queja
                                            </label>
                                            <select v-model="fechaSeleccionada" id="fechaSeleccionada"
                                                class="w-full px-4 py-2 border border-vw-tin-grey rounded-md text-vw-dark-blue focus:outline-none focus:ring-2 focus:ring-vw-light-blue transition duration-150 ease-in-out">
                                                <option value="">Todas</option>
                                                <option value="3_meses">Últimos 3 meses</option>
                                                <option value="6_meses">Últimos 6 meses</option>
                                                <option value="1_año">Último año</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <button @click="limpiarFiltros"
                                            class="px-6 py-2 bg-vw-dark-blue text-white rounded-md hover:bg-vw-light-blue transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-vw-light-blue focus:ring-opacity-50">
                                            Limpiar Filtros
                                        </button>
                                    </div>
                                </div>
                            </transition>

                            <div class="flex justify-between items-center mt-4">
                                <Link :href="route('reporte.create')"
                                    class="px-4 py-2 bg-vw-light-blue text-white rounded hover:bg-vw-dark-blue transition duration-300 font-vwheadlight">
                                Agregar Reporte
                                </Link>
                                <div v-if="isSearching" class="flex items-center text-vw-dark-blue">
                                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Buscando..🔍
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="p-6">
                <div class="bg-white shadow-lg rounded-lg p-4 text-center text-vw-dark-blue font-vwtext">
                    Total de registros: {{ filteredReportes.length }}
                </div>
            </div> -->

            <div class="p-6">
                <div v-if="noHayReportes"
                    class="bg-white shadow-lg rounded-lg p-6 text-center text-vw-dark-blue font-vwtext">
                    No hay Reportes
                </div>
                <div v-else class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <!-- <span class="text-end items-end justify-end w-full">Total de registros: {{ filteredReportes.length }}</span> -->
                        <table class="min-w-full divide-y divide-vw-tin-grey">
                            <thead class="bg-vw-sky-blue">
                                <tr>
                                    <th v-for="header in ['Num. Folio', 'Fecha de la queja', 'Departamento', '¿Procede la Queja?', 'Estado', 'Acciones']"
                                        :key="header" scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-vw-dark-blue uppercase tracking-wider">
                                        {{ header }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-vw-tin-grey">
                                <tr v-for="infoReporte in paginatedReportes" :key="infoReporte.id"
                                    class="hover:bg-vw-light-grey transition duration-300">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-vw-dark-blue">{{
                                        infoReporte.numFolio }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-vw-dark-blue">{{
                                        infoReporte.fechaQueja }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-vw-dark-blue">{{
                                        infoReporte.departamento }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-vw-dark-blue text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-800': infoReporte.procedeQueja === true,
                                                'bg-red-100 text-red-800': infoReporte.procedeQueja === false,
                                                'bg-yellow-100 text-yellow-800': infoReporte.procedeQueja === 'Pendiente'
                                            }">
                                            {{ infoReporte.procedeQueja === true ? 'Si' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-vw-dark-blue">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            :class="{
                                                'bg-green-100 text-green-800': infoReporte.estado === true,
                                                'bg-red-100 text-red-800': infoReporte.estado === false,
                                                'bg-yellow-100 text-yellow-800': infoReporte.estado === 'Pendiente'
                                            }">
                                            {{ infoReporte.estado === true ? 'Activo' : 'Finalizado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <Link :href="`/reporte/${infoReporte.id}`"
                                            class="text-vw-light-blue hover:text-vw-dark-blue mr-2">Ver reporte</Link>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-center items-center p-4 bg-vw-light-grey">
                        <button @click="prevPage" :disabled="currentPage === 1"
                            class="px-4 py-2 bg-vw-dark-blue text-white rounded hover:bg-vw-light-blue transition duration-300 disabled:opacity-50 mr-5">
                            Anterior
                        </button>
                        <span class="text-vw-dark-blue">Página {{ currentPage }} de {{ totalPages }}</span>
                        <button @click="nextPage" :disabled="currentPage === totalPages"
                            class="px-4 py-2 bg-vw-dark-blue text-white rounded hover:bg-vw-light-blue transition duration-300 disabled:opacity-50 ml-5">
                            Siguiente
                        </button>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>


<style>
:root {
    --vw-dark-blue: rgb(0, 30, 80);
    --vw-light-blue: rgb(0, 76, 240);
    --vw-lake-blue: rgb(0, 130, 214);
    --vw-sky-blue: rgb(169, 227, 255);
    --vw-tin-grey: rgb(194, 202, 207);
    --vw-light-grey: rgb(223, 228, 232);
}

.bg-vw-dark-blue {
    background-color: var(--vw-dark-blue);
}

.bg-vw-light-blue {
    background-color: var(--vw-light-blue);
}

.bg-vw-lake-blue {
    background-color: var(--vw-lake-blue);
}

.bg-vw-sky-blue {
    background-color: var(--vw-sky-blue);
}

.bg-vw-tin-grey {
    background-color: var(--vw-tin-grey);
}

.bg-vw-light-grey {
    background-color: var(--vw-light-grey);
}

.text-vw-dark-blue {
    color: var(--vw-dark-blue);
}

.text-vw-light-blue {
    color: var(--vw-light-blue);
}

.text-vw-lake-blue {
    color: var(--vw-lake-blue);
}

.text-vw-sky-blue {
    color: var(--vw-sky-blue);
}

.text-vw-tin-grey {
    color: var(--vw-tin-grey);
}

.text-vw-light-grey {
    color: var(--vw-light-grey);
}

.border-vw-tin-grey {
    border-color: var(--vw-tin-grey);
}

.hover\:bg-vw-dark-blue:hover {
    background-color: var(--vw-dark-blue);
}

.hover\:bg-vw-light-blue:hover {
    background-color: var(--vw-light-blue);
}

.hover\:text-vw-dark-blue:hover {
    color: var(--vw-dark-blue);
}

.focus\:ring-vw-light-blue:focus {
    --tw-ring-color: var(--vw-light-blue);
}

@keyframes modal-in {
    0% {
        transform: scale(0.95);
        opacity: 0;
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes modal-out {
    0% {
        transform: scale(1);
        opacity: 1;
    }

    100% {
        transform: scale(0.95);
        opacity: 0;
    }
}

.modal-content-enter-active {
    animation: modal-in 0.3s ease-out;
}

.modal-content-leave-active {
    animation: modal-out 0.3s ease-in;
}
</style>
