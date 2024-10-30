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

const form = useForm(
    {
        estado: true
    }

);



const showDeleteModal = ref(false);
const reporteToDelete = ref(null);




function toogleStatus(id) {

    form.post(route('reporte.toggleEstado', id), {

        onSuccess: () => {
            console.log('Cambiando estado del reporte:', id);
        },

        onFinish: () => {
            console.log('Cambiando estado del reporte:', id);
        }

    })
}

const openDeleteModal = (reporte) => {
    reporteToDelete.value = reporte;
    showDeleteModal.value = true;
    document.body.style.overflow = 'hidden'; // Previene el scroll del body
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    reporteToDelete.value = null;
    document.body.style.overflow = ''; // Restaura el scroll del body
};

const deleteReporte = () => {
    // Aquí iría la lógica para eliminar el reporte
    console.log('Eliminando reporte:', reporteToDelete.value);
    closeDeleteModal();
};





const searchQuery = ref(''); // Búsqueda por folio único
const advancedSearch = ref(false); // Toggle para activar la búsqueda avanzada

// Campos de búsqueda avanzada
const departamento = ref('');
const calificacion = ref('');
const estado = ref('');
const procedeQueja = ref('');
const fechaSeleccionada = ref(''); // Almacena el rango de tiempo seleccionado
const fechaEspecifica = ref('');

const isSearching = ref(false);
const noHayReportes = ref(false);




const toggleAdvancedSearch = () => {
    advancedSearch.value = !advancedSearch.value;
    if (!advancedSearch.value) {
        limpiarFiltros();
    }
};

const buscarReportes = () => {
    // Esta función ahora actualizará el filteredReportes
    applyFilters();
};

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

const filteredReportes = ref(props.reporte);

const applyFilters = () => {
    filteredReportes.value = props.reporte.filter(infoReporte => {
        if (!advancedSearch.value) {
            // Búsqueda por folio único
            return !searchQuery.value || infoReporte.numFolio.toString().toLowerCase().includes(searchQuery.value.toLowerCase());
        } else {
            // Búsqueda avanzada
            const cumpleDepartamento = !departamento.value || infoReporte.departamento.toLowerCase().includes(departamento.value.toLowerCase());
            const cumpleCalificacion = !calificacion.value || infoReporte.calificacion.toString().includes(calificacion.value);
            const cumpleEstado = !estado.value || ((infoReporte.estado ? 'activo' : 'finalizado') === estado.value);
            const cumpleProcedeQueja = !procedeQueja.value || ((infoReporte.procedeQueja ? 'si' : 'no') === procedeQueja.value);
            const cumpleFecha = checkFechaQueja(infoReporte.fechaQueja);

            return cumpleDepartamento && cumpleCalificacion && cumpleEstado && cumpleProcedeQueja && cumpleFecha;
        }
    });
    // Actualizar el mensaje de "No hay reportes"
    noHayReportes.value = filteredReportes.value.length === 0;
};

const checkFechaQueja = (fechaQueja) => {
    const hoy = new Date();
    const fecha = new Date(fechaQueja);

    let inicioRango = null;
    let finRango = hoy;

    if (fechaEspecifica.value) {
        const [year, month] = fechaEspecifica.value.split('-');
        inicioRango = new Date(year, month - 1, 1);
        finRango = new Date(year, month, 0, 23, 59, 59);
    }

    if (fechaSeleccionada.value) {
        switch (fechaSeleccionada.value) {
            case '1_mes':
                inicioRango = inicioRango ? new Date(inicioRango) : new Date(hoy);
                inicioRango.setMonth(inicioRango.getMonth() - 1);
                break;
            case '3_meses':
                inicioRango = inicioRango ? new Date(inicioRango) : new Date(hoy);
                inicioRango.setMonth(inicioRango.getMonth() - 2);
                break;
            case '6_meses':
                inicioRango = inicioRango ? new Date(inicioRango) : new Date(hoy);
                inicioRango.setMonth(inicioRango.getMonth() - 5);
                break;
            case '1_año':
                inicioRango = inicioRango ? new Date(inicioRango) : new Date(hoy);
                inicioRango.setFullYear(inicioRango.getFullYear() - 1);
                break;
            case 'anteriores':
                inicioRango = inicioRango ? new Date(inicioRango) : new Date(hoy);
                inicioRango.setFullYear(inicioRango.getFullYear() - 1);
                finRango = inicioRango;
                inicioRango = null;
                break;
            default:
                break;
        }
    }

    if (inicioRango) {
        return fecha >= inicioRango && fecha <= finRango;
    } else {
        return fecha <= finRango;
    }
};


// Aplicar filtros cuando cambie cualquier valor de búsqueda
watch([searchQuery, advancedSearch, departamento, calificacion, estado, procedeQueja, fechaSeleccionada, fechaEspecifica], async () => {
    isSearching.value = true;
    await new Promise(resolve => setTimeout(resolve, 300)); // Debounce
    applyFilters();
    isSearching.value = false;
});

// Exponer filteredReportes para que el componente padre pueda acceder a él
defineExpose({ filteredReportes });


console.log(props.reporte);
</script>


<template>

    <Head title="Reportes" />

    <AuthenticatedLayout>
        <div class="bg-gray-100 p-4">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-4">
                        <div class="mb-6">
                            <div class="relative">
                                <input v-if="!advancedSearch" v-model="searchQuery" type="text"
                                    placeholder="Buscar por número de folio..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" />
                                <button @click="toggleAdvancedSearch"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition duration-300">
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

                        <transition enter-active-class="transition duration-300 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-200 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0">
                            <div v-if="advancedSearch" class="bg-gray-50 rounded-lg p-6 mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="departamento">Departamento</label>
                                        <input v-model="departamento" id="departamento" type="text"
                                            placeholder="Buscar por departamento"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="calificacion">Calificación</label>
                                        <input v-model="calificacion" id="calificacion" type="text"
                                            placeholder="Buscar por calificación"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="estado">Estado</label>
                                        <select v-model="estado" id="estado"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Selecciona estado</option>
                                            <option value="activo">Activo</option>
                                            <option value="finalizado">Finalizado</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="procedeQueja">¿Procede Queja?</label>
                                        <select v-model="procedeQueja" id="procedeQueja"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Selecciona</option>
                                            <option value="si">Sí</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <!-- Elegir la fecha en meses en actual seria por ejemplo la fecha actual, en este caso: Octubre 24, pero ahi ya seria en Rango de fecha de queja-->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="fechaEspecifica">Fecha específica</label>
                                        <input type="month" v-model="fechaEspecifica" id="fechaEspecifica"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2"
                                            for="fechaSeleccionada">Rango de Fecha de Queja</label>
                                        <select v-model="fechaSeleccionada" id="fechaSeleccionada"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Todas</option>
                                            <option value="1_mes">Último mes</option>
                                            <option value="3_meses">Últimos 3 meses</option>
                                            <option value="6_meses">Últimos 6 meses</option>
                                            <option value="1_año">Último año</option>
                                            <option value="anteriores">Años anteriores</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Button para limpiar filtros -->
                                <button @click="limpiarFiltros" class="px-4 py-2 my-9 bg-red-500 text-white rounded hover:bg-red-
                             700">Limpiar Filtros</button>
                            </div>
                        </transition>

                        <div class="flex justify-between items-center mt-4">
                            <Link :href="route('reporte.create')"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
                            Agregar Reporte
                            </Link>



                            <div v-if="isSearching" class="flex items-center text-gray-500">
                                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
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

        <div class="p-4">
            <div class="bg-white shadow-md rounded-lg overflow-x-auto" v-if="noHayReportes">
                No hay Reportes

            </div>
            <div class="bg-white shadow-md rounded-lg overflow-x-auto" v-else>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Num.
                                Folio</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha de la queja</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departamento</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ¿Procede
                                la Queja?</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="infoReporte in filteredReportes" :key="infoReporte.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ infoReporte.numFolio }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ infoReporte.fechaQueja }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ infoReporte.departamento }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="{
                                    'bg-green-100 text-green-800': infoReporte.procedeQueja === true,
                                    'bg-red-100 text-red-800': infoReporte.procedeQueja === false,
                                    'bg-yellow-100 text-yellow-800': infoReporte.procedeQueja === 'Pendiente'
                                }">
                                    {{ infoReporte.procedeQueja === true ? 'Si' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="{
                                    'bg-green-100 text-green-800': infoReporte.estado === true,
                                    'bg-red-100 text-red-800': infoReporte.estado === false,
                                    'bg-yellow-100 text-yellow-800': infoReporte.estado === 'Pendiente'
                                }">
                                    {{ infoReporte.estado === true ? 'Activo' : 'Finalizado' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">


                                <Link :href="`/reporte/${infoReporte.id}`"
                                    class="text-blue-600 hover:text-blue-900 mr-2">Ver
                                </Link>

                                <button v-if="infoReporte.estado" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                    Editar
                                </button>
                                <!-- <button @click="toogleStatus(infoReporte)" class="text-green-600 hover:text-blue-900 mr-2">
                                    Cambiar Estado
                                </button> -->
                                <button @click="openDeleteModal(infoReporte)" class="text-red-600 hover:text-red-900">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de confirmación de eliminación -->
        <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Eliminar reporte
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            ¿Estás seguro de que deseas eliminar este reporte? Esta acción no se puede
                                            deshacer.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="deleteReporte" type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Eliminar
                            </button>
                            <button @click="closeDeleteModal" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </AuthenticatedLayout>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-to,
.modal-leave-from {
    opacity: 1;
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
