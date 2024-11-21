<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { CheckCircleIcon } from 'lucide-vue-next';

const props = defineProps({
    empleados: {
        type: Object
    }
});

const form = useForm({
    nombre: '',
    rol: '',
});

const showModal = ref(false);
const isLoading = ref(false);
const errorMessage = ref('');

const add = () => {
    isLoading.value = true;
    form.post(route('empleados.store'), {
        onSuccess: () => {
            form.reset();
            isLoading.value = false;
            showModal.value = true;

            setTimeout(() => {
                showModal.value = false;
                window.location.href = route('empleados.index');
            }, 2000);
        },
        onError: () => {
            isLoading.value = false;


        }
    });
};
</script>

<template>

    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-2xl font-semibold text-gray-800">Formulario Empleados</h1>
        </template>

        <div class="p-4 space-y-8 font-vwtext">

            <!-- Mostrar el span de error -->
            <span v-if="errorMessage" class="text-red-500 text-sm">{{ errorMessage }}</span>

            <form @submit.prevent="add" class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="text" id="nombre" v-model="form.nombre" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                        focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                </div>

                <div class="mb-6">
                    <label for="rol" class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                    <select id="rol" v-model="form.rol"
                        class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
                        <option value="" disabled selected>Selecciona un rol</option>
                        <!-- <option value="Administrador">Administrador</option> -->
                        <option value="Asesor">Asesor</option>
                        <option value="Tecnico">Técnico</option>
                        <!-- <option value="Personal">Personal</option> -->
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <Link :href="route('empleados.index')"
                        class="px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-300">
                    Cancelar
                    </Link>

                    <button type="submit"
                        class="px-4 py-2 bg-sky-500 text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors duration-300 flex items-center"
                        :disabled="isLoading">
                        <span v-if="isLoading" class="mr-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        {{ isLoading ? 'Enviando...' : 'Enviar' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Modal de éxito -->
        <transition enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 transform scale-90" enter-to-class="opacity-100 transform scale-100"
            leave-active-class="transition ease-in duration-300" leave-from-class="opacity-100 transform scale-100"
            leave-to-class="opacity-0 transform scale-90">
            <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="bg-white rounded-lg p-8 shadow-xl z-10 max-w-md w-full m-4">
                    <div class="flex items-center justify-center mb-4 text-green-600">
                        <CheckCircleIcon size="48" class="animate-bounce" />
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-center text-gray-900">¡Éxito!</h3>
                    <p class="text-gray-700 text-center">El empleado se ha añadido correctamente.</p>
                </div>
            </div>
        </transition>
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes bounce {

    0%,
    100% {
        transform: translateY(-25%);
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }

    50% {
        transform: translateY(0);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

.animate-bounce {
    animation: bounce 1s infinite;
}
</style>
