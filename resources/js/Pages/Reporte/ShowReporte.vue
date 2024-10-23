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

const form = useForm(
    {
        estado: true
    }

);


console.log(props.reporte);


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

</script>

<template>

    <Head title="Reporte Show" />

    <AuthenticatedLayout>
        <template #header>
            Reporte: No. Folio - {{ props.reporte.numFolio }}
        </template>

        <div class="py-12 bg-white">

            <!-- Seccion Informacion -->
            <h1 class="font-vwheadbold"> Folio :{{ props.reporte.numFolio }}</h1>
            <h1>{{ props.reporte.departamento }}</h1>
            <p>{{ props.reporte.calificacion }}</p>


            <p>{{ props.reporte.nomCliente }}</p>
            <p>{{ props.reporte.tecnico }}</p>

            <p>Estado: {{ props.reporte.estado ? 'Activo' : 'Inactivo' }}</p>

            <!-- <button @click="toogleStatus(props.reporte.id)">Cambiar Estado</button> -->

            <button @click="toogleStatus(props.reporte.id)" class="text-green-600 hover:text-blue-900 mr-2">
                                    Cambiar Estado
                                </button>

            <Link :href="route('reporte.index')" >Regresar</Link>
        </div>



    </AuthenticatedLayout>
</template>

<style scoped>

</style>
