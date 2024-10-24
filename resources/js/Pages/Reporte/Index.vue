<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

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

//Busqueda

const searchQuery = ref(''); // Variable para almacenar el valor del campo de búsqueda



function toogleStatus(id){

    form.post(route('reporte.toggleEstado', id),{

        onSuccess: () => {
            console.log('Cambiando estado del reporte:', id);
        },

        onFinish: () =>{
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


// Computed para filtrar los reportes según el texto de búsqueda
const filteredReportes = computed(() => {
    if (!searchQuery.value) return props.reporte;
    return props.reporte.filter(infoReporte =>
        infoReporte.numFolio.toString().toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        infoReporte.calificacion.toString().toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        infoReporte.departamento.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        (infoReporte.procedeQueja ? 'si' : 'no').toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        (infoReporte.estado ? 'activo' : 'finalizado').toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});


</script>

<template>

    <Head title="Reportes" />

    <AuthenticatedLayout>
        <template #header>
            Reportes Index
        </template>

        <div class="p-4">
            <Link :href="route('reporte.create')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
            Agregar Reporte
            </Link>
        </div>

        <!-- //Agregar la barra de busqueda (filtrador de busqueda) -->
         <!-- Barra de búsqueda -->
         <div class="p-4">
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Buscar reportes..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200"
            />
        </div>

        <div class="p-4">
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Num.
                                Folio</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Calificación</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ infoReporte.calificacion }}
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


                                <Link :href="`/reporte/${infoReporte.id}`" class="text-blue-600 hover:text-blue-900 mr-2">Ver</Link>

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
