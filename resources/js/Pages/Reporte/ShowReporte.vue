<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Info, ClipboardIcon, UserIcon, CarIcon, WrenchIcon, CheckCircleIcon, XCircleIcon, AlertTriangleIcon, CalendarIcon, HashIcon, FolderSearch, FileClock, Loader } from 'lucide-vue-next';



const props = defineProps({
    reporte: {
        type: Object,
        required: true
    }
});

// Formulario específico para el archivo PDF
const formPDF = useForm({
    reportePDF: null,
});
// Función para manejar la selección del archivo
function onFileChange(event) {
    formPDF.reportePDF = event.target.files[0];
}
// Función para subir el archivo PDF
function subirPDF() {
    formPDF.post(route('reporte.subirPDF', props.reporte.id), {
        preserveScroll: true,
        onSuccess: () => {
            formPDF.reset();
        },
        onFinish: () => {
            // Recargar la página para mostrar el archivo PDF
            location.reload();
        }
    });
}
// Función para eliminar el archivo PDF
function eliminarPDF() {
    if (confirm('¿Estás seguro de que deseas eliminar el archivo?')) {
        formPDF.delete(route('reporte.eliminarPDF', props.reporte.id), {
            preserveScroll: true,
        });
    }
}


//FUNCIONES PARA AGREGAR LAS EVIDENCIAS
const formEvidencia = useForm({
    evidenciasReporte: [],
});

function onEvidenciaChange(event) {
    formEvidencia.evidenciasReporte.push(event.target.files[0]);
}

// Función para subir las evidencias
function subirEvidencia() {
    formEvidencia.post(route('reporte.subirEvidencia', props.reporte.id), {
        preserveScroll: true,
        onSuccess: () => {
            formEvidencia.reset();
            location.reload();
        },
        // Mostrar errores si es que hay
        onError: (errors) => {
            console.error(errors);
        },
    });
}

// Función para eliminar una evidencia
function eliminarEvidencia(index) {
    if (confirm('¿Estás seguro de que deseas eliminar esta evidencia?')) {
        formEvidencia.delete(route('reporte.eliminarEvidencia', { id: props.reporte.id, index: index }), {
            preserveScroll: true,
            onSuccess: () => {
                location.reload();
            }
        });
    }
}


const form = useForm({
    estado: true
});

function toggleStatus(id) {
    form.post(route('reporte.toggleEstado', id), {
        preserveState: true,
        preserveScroll: true,
    });
}

function generarPDF($id) {
    window.open(route('reporte.generarPDF', $id), '_blank');
}

function descargarEvidencias() {
    window.open(route('reporte.descargarEvidencias', props.reporte.id), '_blank');
}

function verPDF() {
    window.open(route('reporte.verPDF', props.reporte.id), '_blank');
}



const activeTab = ref('general');
const isLoading = ref(false);

const setActiveTab = (tab) => {
    isLoading.value = true;
    activeTab.value = tab;
    // Simulate loading delay
    setTimeout(() => {
        isLoading.value = false;
    }, 250);
};

// const setActiveTab = (tab) => {
//     activeTab.value = tab;
// };


const currentPage = ref(1);
const itemsPerPage = 10;

const totalPages = computed(() => {
    return Math.ceil(props.reporte.historialCambios.length / itemsPerPage);
});

const paginatedHistorialCambios = computed(() => {
    const reversedHistorial = [...props.reporte.historialCambios].reverse();
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return reversedHistorial.slice(start, end);
});

function formatDate(date) {
    return new Date(date).toLocaleString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function prevPage() {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
}

function nextPage() {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
}


const showDeleteModal = ref(false);

function openDeleteModal(id) {
    showDeleteModal.value = true;
    console.log(id);
}

function confirmDelete() {
    // Lógica para eliminar el reporte
    form.delete(route('reporte.eliminarReporte', props.reporte.id), {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            // Redirigir a la lista de reportes
            location.href = route('reporte.index');
            console.log('Reporte eliminado');
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}

</script>

<template>

    <Head title="Reporte Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center font-vwheadbold ml-8"
                style="color: rgb(0, 30, 80);">
                <ClipboardIcon class="w-6 h-6 mr-2" />
                Reporte: No. Folio - {{ props.reporte.numFolio }}
            </h2>
        </template>

        <div class="pb-12 pt-4 font-vwtext">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="p-6 space-y-1">
                        <!-- Tabs para navegación en móviles -->
                        <div class="sm:hidden">
                            <select v-model="activeTab" @change="setActiveTab(activeTab)"
                                class="block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                style="color: rgb(0, 30, 80);">
                                <option value="general">General</option>
                                <option value="cliente">Cliente</option>
                                <option value="vehiculo">Vehículo</option>
                                <option value="reclamacion">Reclamación</option>
                                <option value="resolucion">Resolución</option>
                                <option value="evidencias">Evidencias</option>
                                <option value="historial">Historial</option>
                            </select>
                        </div>

                        <!-- Tabs para desktop -->
                        <div class="hidden sm:block">
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <a v-for="tab in ['general', 'cliente', 'vehiculo', 'reclamación', 'resolución', 'evidencias', 'historial']"
                                        :key="tab" @click.prevent="setActiveTab(tab)"
                                        :class="[activeTab === tab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer']">
                                        {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <div v-if="isLoading" class="flex justify-center items-center h-64">
                            <Loader class="animate-spin h-8 w-8 text-vw-blue-500" />
                            <span class="ml-2 text-vw-blue-700">Cargando...</span>
                        </div>

                        <div v-else>
                            <!-- Contenido de las pestañas -->
                            <div v-show="activeTab === 'general'" class="space-y-4">
                                <div class="bg-blue-50 p-4 rounded-lg shadow">
                                    <h3 class="text-lg font-semibold mb-4 flex items-center"
                                        style="color: rgb(0, 30, 80);">
                                        <Info class="w-5 h-5 mr-2" />
                                        Información General
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div v-for="(value, key) in {
                                            'Folio': props.reporte.numFolio,
                                            'Departamento': props.reporte.departamento,
                                            'Calificación': props.reporte.calificacion,
                                            'Fecha de Queja': props.reporte.fechaQueja,
                                            'Fecha de Entrega': props.reporte.fechaEntrega,
                                            'Fecha de Ingreso': props.reporte.fechaIngreso,
                                            'Forma de Detección': props.reporte.formaDeteccion,
                                            'Red Social': props.reporte.redSocial
                                        }" :key="key" class="flex items-center">
                                            <span class="font-medium text-blue-700 mr-2">{{ key }}:</span>
                                            <span class="text-blue-900">{{ value || 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 'cliente'" class="space-y-4">
                                <div class="bg-green-50 p-4 rounded-lg shadow">
                                    <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                                        <UserIcon class="w-5 h-5 mr-2" />
                                        Información del Cliente
                                    </h3>
                                    <div class="space-y-2">
                                        <p v-for="(value, key) in {
                                            'Nombre': props.reporte.nomCliente,
                                            'Celular': props.reporte.celularCliente,
                                            'Email': props.reporte.emailCliente,
                                            'Asesor': props.reporte.asesor
                                        }" :key="key" class="flex items-center">
                                            <span class="font-medium text-green-700 mr-2">{{ key }}:</span>
                                            <span class="text-green-900">{{ value }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 'vehiculo'" class="space-y-4">
                                <div class="bg-yellow-50 p-4 rounded-lg shadow">
                                    <h3 class="text-lg font-semibold text-yellow-800 mb-4 flex items-center">
                                        <CarIcon class="w-5 h-5 mr-2" />
                                        Información del Vehículo
                                    </h3>
                                    <div class="space-y-2">
                                        <p v-for="(value, key) in {
                                            'Tipo/Modelo': props.reporte.tipoModelo,
                                            'Placas': props.reporte.placas,
                                            'Color': props.reporte.color,
                                            'No. Orden': props.reporte.noOrden,
                                            'VIN': props.reporte.vin,
                                            'Técnico': props.reporte.tecnico
                                        }" :key="key" class="flex items-center">
                                            <span class="font-medium text-yellow-700 mr-2">{{ key }}:</span>
                                            <span class="text-yellow-900">{{ value || 'N/A' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 'reclamación'" class="space-y-4">
                                <div class="bg-red-50 p-4 rounded-lg shadow">
                                    <h3 class="text-lg font-semibold text-red-800 mb-4 flex items-center">
                                        <AlertTriangleIcon class="w-5 h-5 mr-2" />
                                        Detalles de la Reclamación
                                    </h3>
                                    <div class="space-y-4">
                                        <p v-for="(value, key) in {
                                            'Reclamación': props.reporte.reclamacion,
                                            'Tipo de Reclamación': props.reporte.tipoReclamacion,
                                            'Otro Tipo de Reclamación': props.reporte.otroTipoReclamacion
                                        }" :key="key" class="flex items-center">
                                            <span class="font-medium text-red-700 mr-2">{{ key }}:</span>
                                            <span class="text-red-900">{{ value || 'N/A' }}</span>
                                        </p>

                                        <div>
                                            <h4 class="font-medium text-red-700 mb-2">Causa Raíz:</h4>
                                            <ul class="list-disc list-inside pl-4 space-y-1 text-red-900">
                                                <li v-for="(value, key) in props.reporte.causaRaiz" :key="key">
                                                    {{ key.charAt(0).toUpperCase() + key.slice(1) }}: {{ value || 'N/A'
                                                    }}
                                                </li>
                                            </ul>
                                        </div>

                                        <div>
                                            <h4 class="font-medium text-red-700 mb-2">Medidas:</h4>
                                            <ul class="space-y-2">
                                                <li v-for="(medida, index) in props.reporte.medidas" :key="index"
                                                    class="bg-red-100 p-2 rounded">
                                                    <p><span class="font-medium text-red-700">Medida:</span> <span
                                                            class="text-red-900">{{ medida.medida }}</span></p>
                                                    <p><span class="font-medium text-red-700">Responsable:</span> <span
                                                            class="text-red-900">{{ medida.responsable }}</span></p>
                                                    <p><span class="font-medium text-red-700">Fecha:</span> <span
                                                            class="text-red-900">{{ medida.fecha }}</span></p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 'resolución'" class="space-y-4">
                                <div class="bg-purple-50 p-4 rounded-lg shadow">
                                    <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                                        <CheckCircleIcon class="w-5 h-5 mr-2" />
                                        Resolución y Seguimiento
                                    </h3>
                                    <div class="space-y-4">
                                        <p class="flex items-center">
                                            <span class="font-medium text-purple-700 mr-2">¿Procede la Queja?:</span>
                                            <span
                                                :class="{ 'text-green-600': props.reporte.procedeQueja, 'text-red-600': !props.reporte.procedeQueja }">
                                                {{ props.reporte.procedeQueja ? 'Sí' : 'No' }}
                                            </span>
                                        </p>

                                        <div v-if="props.reporte.procedeQueja" class="text-purple-900">

                                            <p class="flex items-center mb-3">
                                                <span class="font-medium text-purple-700 mr-2">Solución: </span>
                                                <span>
                                                    {{ props.reporte.solucion }}
                                                </span>
                                            </p>

                                            <p class="flex items-center mb-3">
                                                <span class="font-medium text-purple-700 mr-2">Nombre del empleado que
                                                    realizó
                                                    el cierre: </span>
                                                <span>
                                                    {{ props.reporte.nombreCierre }}
                                                </span>
                                            </p>

                                            <p class="flex items-center mb-3">
                                                <span class="font-medium text-purple-700 mr-2">Fecha de cierre: </span>
                                                <span>
                                                    {{ props.reporte.fechaCierre }}
                                                </span>
                                            </p>

                                            <p class="flex items-center mb-3">
                                                <span class="font-medium text-purple-700 mr-2">Personal que realizó el
                                                    contacto
                                                    de seguimiento : </span>
                                                <span>
                                                    {{ props.reporte.nombreSeguimiento }}
                                                </span>
                                            </p>

                                            <p class="flex items-center mb-3">
                                                <span class="font-medium text-purple-700 mr-2">Fecha de contacto de
                                                    seguimiento:
                                                </span>
                                                <span>
                                                    {{ props.reporte.fechaSeguimiento }}
                                                </span>
                                            </p>

                                            <p class="flex items-center mb-3">
                                                <span class="font-medium text-purple-700 mr-2">Comentarios del cliente:
                                                </span>
                                                <span>
                                                    {{ props.reporte.comentariosCliente }}
                                                </span>
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 'evidencias'" class="space-y-8">
                                <div class="bg-yellow-50 p-6 rounded-lg shadow-lg">
                                    <h3 class="text-2xl font-semibold text-yellow-800 mb-6 flex items-center">
                                        <FolderSearch class="w-6 h-6 mr-2" />
                                        Evidencias
                                    </h3>

                                    <div class="space-y-6">
                                        <div>
                                            <h4 class="text-lg font-medium text-yellow-700 mb-4">Evidencias del Reporte
                                            </h4>
                                            <!-- Template para mostrar las evidencias -->
                                            <template
                                                v-if="props.reporte.evidenciasReporte && props.reporte.evidenciasReporte.length">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div v-for="(evidencia, index) in props.reporte.evidenciasReporte"
                                                        :key="index"
                                                        class="bg-white p-4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                                        <img :src="`/storage/${evidencia}`" alt="Evidencia del Reporte"
                                                            class="w-full h-48 object-cover rounded-md mb-3">
                                                        <button v-if="props.reporte.estado"
                                                            @click="eliminarEvidencia(index)"
                                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>

                                            <template v-else>
                                                <p class="text-gray-600 italic">No hay evidencias guardadas.</p>
                                            </template>

                                            <!-- Formulario para subir nuevas evidencias -->
                                            <form v-if="props.reporte.estado" @submit.prevent="subirEvidencia"
                                                enctype="multipart/form-data" class="mt-6 bg-white p-5">
                                                <div
                                                    class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                                                    <label for="evidencia"
                                                        class="w-full sm:w-auto flex-shrink-0 text-sm font-medium text-gray-700">
                                                        Subir nueva evidencia
                                                    </label>
                                                    <div class="w-full flex space-x-2">
                                                        <input type="file" id="evidencia" @change="onEvidenciaChange"
                                                            accept="image/*"
                                                            class="flex-grow text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                                                        <button type="submit"
                                                            class="flex-shrink-0 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                                            Subir
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Boton para descargar Evidencias -->
                                            <button @click="descargarEvidencias"
                                                class="inline-flex items-center justify-center px-4 py-2 my-4 bg-blue-600 text-white font-medium rounded-md transition duration-300 ease-in-out hover:bg-blue-700">
                                                Descargar Evidencias
                                            </button>
                                        </div>

                                        <div>
                                            <h4 class="text-lg font-medium text-yellow-700 mb-4">Reporte PDF escaneado
                                            </h4>

                                            <!-- Si ya hay un archivo PDF guardado, muestra el archivo con opciones para descargar o eliminar -->
                                            <div class="bg-white p-4 rounded-lg shadow-md">
                                                <template v-if="props.reporte.reportePDF">
                                                    <p class="text-gray-700 mb-3">Archivo actual: {{
                                                        props.reporte.reportePDF }}</p>
                                                    <div class="flex space-x-3">
                                                        <!-- Boton para ver el PDF -->
                                                        <button @click="verPDF"
                                                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                                            Ver
                                                        </button>

                                                        <button v-if="props.reporte.estado" @click="eliminarPDF"
                                                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <p class="text-gray-600 italic mb-4">No hay archivo PDF guardado.
                                                    </p>
                                                    <!-- Formulario para subir o reemplazar el archivo PDF -->
                                                    <form @submit.prevent="subirPDF">
                                                        <div
                                                            class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                                                            <label for="reportePDF"
                                                                class="w-full sm:w-auto flex-shrink-0 text-sm font-medium text-gray-700">
                                                                Subir nuevo archivo PDF
                                                            </label>
                                                            <div class="w-full flex space-x-2">
                                                                <input type="file" id="reportePDF"
                                                                    @change="onFileChange" accept=".pdf"
                                                                    class="flex-grow text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                                                                <button type="submit"
                                                                    class="flex-shrink-0 bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                                                    Subir
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 'historial'"
                                class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                <div class="bg-vw-blue-100 p-4 sm:p-6 rounded-lg shadow-lg">
                                    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
                                        <h3 class="text-xl font-bold text-vw-blue-900 flex items-center mb-2 sm:mb-0">
                                            <FileClock class="w-6 h-6 mr-2 text-vw-blue-700" />
                                            Historial
                                        </h3>
                                        <span class="text-sm font-medium text-vw-blue-700">
                                            Página {{ currentPage }} de {{ totalPages }}
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
                                        <div v-for="(historial, index) in paginatedHistorialCambios" :key="index"
                                            class="bg-white bg-opacity-80 p-3 rounded-md shadow-sm">
                                            <div v-for="(cambio, cambioIndex) in historial.cambios" :key="cambioIndex"
                                                class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                                <div class="flex items-center">
                                                    <span class="font-medium text-vw-blue-700 mr-2">Fecha:</span>
                                                    <span class="text-vw-blue-900">{{ formatDate(cambio.fecha) || 'N/A'
                                                        }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="font-medium text-vw-blue-700 mr-2">Descripción:</span>
                                                    <span class="text-vw-blue-900">{{ cambio.descripcion || 'N/A'
                                                        }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-center space-x-2">
                                        <button @click="prevPage" :disabled="currentPage === 1"
                                            class="px-3 py-1 text-sm rounded transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-vw-blue-500"
                                            :class="currentPage === 1 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-vw-blue-500 text-white hover:bg-vw-blue-600'">
                                            Anterior
                                        </button>
                                        <button @click="currentPage = 1" :disabled="currentPage === 1"
                                            class="p-1 rounded transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-vw-blue-500"
                                            :class="currentPage === 1 ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-vw-blue-500 text-white hover:bg-vw-blue-600'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-rotate-ccw">
                                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                                <path d="M3 3v5h5" />
                                            </svg>
                                        </button>
                                        <button @click="nextPage" :disabled="currentPage === totalPages"
                                            class="px-3 py-1 text-sm rounded transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-vw-blue-500"
                                            :class="currentPage === totalPages ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-vw-blue-500 text-white hover:bg-vw-blue-600'">
                                            Siguiente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado y Acciones -->
                        <div
                            class="mt-8 flex flex-col sm:flex-row items-center justify-between bg-gray-100 p-4 rounded-lg">
                            <div class="flex items-center mb-4 sm:mb-0">
                                <span class="font-medium mr-2">Estado:</span>
                                <span :class="props.reporte.estado ? 'text-green-600' : 'text-red-600'"
                                    class="font-bold">
                                    {{ props.reporte.estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>

                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">

                                <!-- //Link para ir a  -->
                                <Link v-if="props.reporte.estado" :href="route('reporte.edit', props.reporte.id,)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white border border-transparent rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                Editar
                                </Link>

                                <button @click="openDeleteModal(props.reporte.id)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white border border-transparent rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition">Eliminar</button>
                            </div>

                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">

                                <button @click="generarPDF(props.reporte.id)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white border border-transparent rounded-md font-semibold text-xs  uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                                    Descargar PDF
                                </button>

                                <button v-if="props.reporte.estado === true" @click="toggleStatus(props.reporte.id)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    Finalizar Reporte
                                </button>
                                <Link :href="route('reporte.index')"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                Regresar
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aqui puede ir el transition para el modal -->

        <transition name="modal-fade">
            <div v-if="showDeleteModal" class="fixed inset-0 flex items-center justify-center z-50 font-vwtext">
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="bg-white rounded-lg shadow-lg p-6 z-10">
                    <h3 class="text-lg font-vwheadbold mb-4 text-center">Confirmar Eliminación</h3>
                    <p class="mb-6">¿Estás seguro de que deseas eliminar este reporte?</p>
                    <div class="flex justify-center space-x-4">
                        <button @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-300 rounded-md">Cancelar</button>
                        <button @click="confirmDelete"
                            class="px-4 py-2 bg-red-600 text-white rounded-md">Eliminar</button>
                    </div>
                </div>
            </div>
        </transition>

    </AuthenticatedLayout>
</template>


<style>
:root {
    --vw-blue-100: #e6f0ff;
    --vw-blue-500: #0066b2;
    --vw-blue-600: #005091;
    --vw-blue-700: #003d70;
    --vw-blue-900: #001f3f;
}

.bg-vw-blue-100 {
    background-color: var(--vw-blue-100);
}

.bg-vw-blue-500 {
    background-color: var(--vw-blue-500);
}

.text-vw-blue-700 {
    color: var(--vw-blue-700);
}

.text-vw-blue-900 {
    color: var(--vw-blue-900);
}

.hover\:bg-vw-blue-600:hover {
    background-color: var(--vw-blue-600);
}

.focus\:ring-vw-blue-500:focus {
    --tw-ring-color: var(--vw-blue-500);
}
</style>
