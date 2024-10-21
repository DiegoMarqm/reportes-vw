<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';


// Inicializamos el formulario para agregar reportes
const form = useForm({

});

// Estado para controlar la visibilidad del modal
const showModal = ref(false);

const add = () => {
    form.post(route('reportes.store'), {
        onProgress: () => {
            form.processing = true;
        },
        onSuccess: () => {
            form.reset();
            showModal.value = true;

            setTimeout(() => {
                showModal.value = false;
                window.location.href = route('reportes.index');
            }, 1500);
        }
    });
};
</script>

<template>
    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
         Reportes Index
        </template>

        <div class="p-4">
            <Link :href="route('reporte.create')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Agregar Reporte
            </Link>
        </div>



        <div class="p-4 space-y-8">
            <form @submit.prevent="add" class="bg-white rounded-lg shadow p-6">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Departamento</label>

                </div>


                <div class="flex justify-end">
                    <Link :href="route('reporte.index')" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2">Cancelar
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
                <p class="text-gray-700">El formulario se ha enviado correctamente.</p>
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
