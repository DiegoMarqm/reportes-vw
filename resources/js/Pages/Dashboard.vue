<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Chart,  registerables } from 'chart.js';
import { ref, onMounted } from 'vue';

// Registrar todos los componentes necesarios de Chart.js
Chart.register(...registerables);

const props = defineProps({
    empleadosPorRol: {
        type: Array,
        required: true
    }
});

const ChartRef = ref(null);

onMounted(() => {
    const ctx = document.getElementById('empleadosPorRolChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: props.empleadosPorRol.map(item => item.rol),
            datasets: [{
                label: 'No. de Empleados',
                data: props.empleadosPorRol.map(item => item.total),
                // backgroundColor: 'rgba(75, 192, 192, 0.2)',
                backgroundColor: 'rgba(0,30,70, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

console.log(props.empleadosPorRol);

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            You're logged in!
        </div>
        <div class="p-4 bg-white rounded-lg shadow-xs">
            hola
        </div>

        <div class="p-4 bg-white rounded-lg shadow-xs w-1/3">
            <canvas id="empleadosPorRolChart"></canvas>
        </div>


    </AuthenticatedLayout>
</template>

<!-- <template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="p-4">
            <div class="min-w-screen mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="min-w-screen mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        hola
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> -->
