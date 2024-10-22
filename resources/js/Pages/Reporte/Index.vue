<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    reporte: {
        type: Object,
        required: true
    }
});

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


console.log(props.reporte);


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



        <div class="p-4 space-y-8 bg-white rounded-lg shadow" v-for="infoReporte in reporte" :key="infoReporte.id">
            <h1>{{ infoReporte.numFolio }}</h1>
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
