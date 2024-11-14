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

// Controlar el estado del modal
const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

// Función para agregar empleado
const add = () => {
    form.post(route('empleados.store'), {
        onProgress: () => {
            form.processing = true;
            form.reset();
        },
        onFinish: () => {
            form.reset();
            closeModal();
        }
    });
};

// Función para eliminar empleado
const eliminarEmpleado = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
        form.delete(route('empleados.destroy', id), {
            onSuccess: () => {
                // Aquí puedes recargar la página o hacer otra acción al eliminar
            }
        });
    }
};

// console.log(props.empleados)

</script>

<template>

    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            Empleados
        </template>

        <!-- Botón para abrir el modal -->
        <div class="p-4">
            <Link :href="route('empleados.create')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
            Agregar
            </Link>
        </div>

        <!-- Mostrar empleados agrupados por rol -->
        <div class="p-4 space-y-8">
            <!-- Se recorre cada rol dentro de los empleados -->
            <div v-for="(empleadosPorRol, rol) in empleados" :key="rol" class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">{{ rol }}</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <!-- <th class="py-2 px-4">ID</th> -->
                            <th class="py-2 px-4">Nombre</th>
                            <th class="py-2 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="empleado in empleadosPorRol" :key="empleado.id">
                            <!-- <td class="border px-4 py-2">{{ empleado.id }}</td> -->
                            <td class="border px-4 py-2">{{ empleado.nombre }}</td>
                            <td class="border px-4 py-2 text-center">
                                <!-- Botón de eliminar -->
                                <button @click="eliminarEmpleado(empleado.id)" class="text-red-600 hover:text-red-800">
                                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#f00000">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M4 20V19C4 16.2386 6.23858 14 9 14H12.75M16 15L18.5 17.5M18.5 17.5L21 20M18.5 17.5L21 15M18.5 17.5L16 20M15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z"
                                                stroke="#ff0000" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </g>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
}
</style>
