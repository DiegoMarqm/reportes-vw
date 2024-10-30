<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ClipboardIcon, UserIcon, CarIcon, WrenchIcon, CheckCircleIcon, XCircleIcon, AlertTriangleIcon, CalendarIcon, HashIcon } from 'lucide-vue-next';



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


//Aqui quiero hacer lo mismo pero 'evidenciasReporte' es un array y contendra imagenes, podemos

const form = useForm({
    estado: true
});

function toggleStatus(id) {
    form.post(route('reporte.toggleEstado', id), {
        preserveState: true,
        preserveScroll: true,
    });
}

function generaPDF($id) {
    window.open(route('reporte.generarPDF', $id), '_blank');
}



const activeTab = ref('general');

const setActiveTab = (tab) => {
    activeTab.value = tab;
};
</script>

<template>

    <Head title="Reporte Show" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <ClipboardIcon class="w-6 h-6 mr-2" />
                Reporte: No. Folio - {{ props.reporte.numFolio }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="p-6 space-y-6">
                        <!-- Tabs para navegación en móviles -->
                        <div class="sm:hidden">
                            <select v-model="activeTab"
                                class="block w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
                                    <a v-for="tab in ['general', 'cliente', 'vehiculo', 'reclamacion', 'resolucion', 'evidencias', 'historial']"
                                        :key="tab" @click.prevent="setActiveTab(tab)"
                                        :class="[activeTab === tab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm cursor-pointer']">
                                        {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <!-- Contenido de las pestañas -->
                        <div v-show="activeTab === 'general'" class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                                    <HashIcon class="w-5 h-5 mr-2" />
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

                        <div v-show="activeTab === 'reclamacion'" class="space-y-4">
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
                                                {{ key }}: {{ value }}
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

                        <div v-show="activeTab === 'resolucion'" class="space-y-4">
                            <div class="bg-purple-50 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold text-purple-800 mb-4 flex items-center">
                                    <CheckCircleIcon class="w-5 h-5 mr-2" />
                                    Resolución y Seguimiento
                                </h3>
                                <div class="space-y-4">
                                    <p v-for="(value, key) in {
                                        '¿Procede la Queja?': props.reporte.procedeQueja ? 'Sí' : 'No',
                                        'Solución': props.reporte.solucion,
                                        'Nombre de Cierre': props.reporte.nombreCierre,
                                        'Fecha de Cierre': props.reporte.fechaCierre,
                                        'Nombre de Seguimiento': props.reporte.nombreSeguimiento,
                                        'Fecha de Seguimiento': props.reporte.fechaSeguimiento,
                                        'Comentarios del Cliente': props.reporte.comentariosCliente
                                    }" :key="key" class="flex items-center">
                                        <span class="font-medium text-purple-700 mr-2">{{ key }}:</span>
                                        <span
                                            :class="{ 'text-green-600': key === '¿Procede la Queja?' && value === 'Sí', 'text-red-600': key === '¿Procede la Queja?' && value === 'No', 'text-purple-900': key !== '¿Procede la Queja?' }">
                                            {{ value }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div v-show="activeTab === 'evidencias'" class="space-y-4">
                            <div class="bg-yellow-50 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold text-yellow-800 mb-4 flex items-center">
                                    <WrenchIcon class="w-5 h-5 mr-2" />
                                    Evidencias
                                </h3>

                                <div class="space-y-2">
                                    Evidencias del Reporte
                                    <!-- Aqui quiero que usemos evidenciasReporte para hacer casi lo mismo del PDF, solo que aqui se podran añadir Imagenes, tendremos un espacio para visualizar las imagenes y cada una se podra eliminar, tambien quiero que haya un boton para que se suba una nueva evidencia -->


                                </div>


                                <div class="space-y-2">
                                    Reporte PDF escaneado
                                </div>

                                <!-- Si ya hay un archivo PDF guardado, muestra el archivo con opciones para descargar o eliminar -->
                                <div class="space-y-2">

                                    <template v-if="props.reporte.reportePDF">
                                        <p class="text-gray-700">Archivo actual: {{ props.reporte.reportePDF }}</p>
                                        <a :href="`/storage/escaneo/${props.reporte.reportePDF}`"
                                            class="bg-green-500 text-white px-3 py-1 rounded-lg" download>Descargar
                                            PDF</a>
                                        <button @click="eliminarPDF"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg">Eliminar</button>
                                    </template>
                                    <template v-else>
                                        <p class="text-gray-700 mb-10">No hay archivo PDF guardado.</p>
                                        <!-- <p>No hay ningún archivo cargado.</p> -->
                                        <!-- Formulario para subir o reemplazar el archivo PDF -->
                                        <form @submit.prevent="subirPDF">
                                            <label for="reportePDF"
                                                class="block text-sm font-medium text-gray-700">Subir
                                                nuevo
                                                archivo PDF</label>
                                            <input type="file" id="reportePDF" @change="onFileChange" accept=".pdf"
                                                class="block w-full text-sm text-gray-500 border-gray-300 rounded-md">
                                            <button type="submit"
                                                class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg">Subir</button>
                                        </form>

                                    </template>




                                </div>
                            </div>
                        </div>


                        <!-- Historial -->
                        <div v-show="activeTab === 'historial'" class="space-y-4">
                            <div class="bg-yellow-50 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-semibold text-yellow-800 mb-4 flex items-center">
                                    <WrenchIcon class="w-5 h-5 mr-2" />
                                    Historial
                                </h3>
                                <div class="space-y-2">
                                    <div v-for="(historial, index) in props.reporte.historialCambios" :key="index">
                                        <!--
                                        <p v-for="(cambios, cambiosIndex) in historial.cambios" :key="cambiosIndex">{{ cambios.descricion }}</p> -->

                                        <div v-for="(cambio, cambioIndex) in historial.cambios" :key="cambioIndex"
                                            class="flex items-center">
                                            <!-- <p class="font-medium text-yellow-700 mr-2">Campo:</p>
                                            <p class="text-yellow-900">{{ cambio.campo || 'N/A' }}</p> -->
                                            <p class="font-medium text-yellow-700 mr-2 ml-4">Fecha:</p>
                                            <p class="text-yellow-900">{{ new Date(cambio.fecha).toLocaleString('es-ES',
                                                {
                                                    day:
                                                        '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute:
                                                        '2-digit'
                                                }) || 'N/A' }}</p>
                                            <p class="font-medium text-yellow-700 mr-2 ml-4">Descripcion:</p>
                                            <p class="text-yellow-900">{{ cambio.descripcion || 'N/A' }}</p>
                                        </div>
                                    </div>


                                    <!-- <p v-for="(value, key) in {
                                        'Historial': props.reporte.historialCambios
                                        // 'Tipo de Reclamación': props.reporte.tipoReclamacion,
                                        // 'Otro Tipo de Reclamación': props.reporte.otroTipoReclamacion
                                    }" :key="key" class="flex items-center">
                                        <span class="font-medium text-red-700 mr-2">{{ key }}:</span>
                                        <span class="text-red-900">{{ value || 'N/A' }}</span>
                                    </p> -->


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
                                <Link :href="route('reporte.edit', props.reporte.id)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white">
                                Editar
                                </Link>
                            </div>

                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">

                                <button @click="generaPDF(props.reporte.id)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white">
                                    Descargar PDF
                                </button>

                                <button @click="toggleStatus(props.reporte.id)"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                                    Cambiar Estado
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
    </AuthenticatedLayout>
</template>

<style scoped>
/* Estilos adicionales si son necesarios */
</style>
