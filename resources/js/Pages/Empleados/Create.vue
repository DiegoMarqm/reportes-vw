<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Propiedades recibidas (empleados)
const props = defineProps({
    empleados: {
        type: Object
    }
});

// Inicializamos el formulario para agregar empleados
const form = useForm({
    nombre: '',
    rol: '',
});

// Estado para controlar la visibilidad del modal
const showModal = ref(false);

const add = () => {
    form.post(route('empleados.store'), {
        onProgress: () => {
            form.processing = true;
        },
        onSuccess: () => {
            form.reset();
            showModal.value = true;

            setTimeout(() => {
                showModal.value = false;
                window.location.href = route('empleados.index');
            }, 1500);
        }
    });
};
</script>

<template>
    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            Formulario Create
        </template>

        <div class="p-4 space-y-8 font-vwtext">
            <form @submit.prevent="add" class="bg-white rounded-lg shadow p-6">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre</label>
                    <input type="text" id="nombre" v-model="form.nombre"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="rol" class="block text-gray-700">Rol</label>
                    <select id="rol" v-model="form.rol"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="Administrador">Administrador</option>
                        <option value="Asesor">Asesor</option>
                        <option value="Tecnico">Tecnico</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <Link :href="route('empleados.index')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2">Cancelar
                    </Link>

                    <input type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
                         value="Enviar">
                </div>
            </form>
        </div>

        <!-- Modal de éxito -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 shadow-xl">
                <div class="text-2xl font-bold mb-4 text-green-600">¡Éxito!</div>
                <p class="text-gray-700">El empleado se ha añadido correctamente.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
}
</style>
