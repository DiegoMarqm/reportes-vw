<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Chart, registerables } from 'chart.js';
import { ref, onMounted, computed } from 'vue';

Chart.register(...registerables);

const props = defineProps({
    empleadosPorRol: {
        type: Array,
        required: true
    },
    reportesTotal: {
        type: Number,
        required: true
    },
    reporteDepartamento: {
        type: Array,
        required: true
    },
    redesSociales: {
        type: Array,
        required: true
    },
    reportesFinalizados: {
        type: Number,
        required: true
    }
});

console.log(props.reportesFinalizados);

const obtenerYearActual = () => new Date().getFullYear();




//reporteDepartamento contiene lo siguiente:
// $reportesTotalesPorDepartamentoTotalYear = Report::select('departamento', DB::raw('count(*) as total'))
// ->whereIn('departamento', ['Ventas', 'Servicio', 'Refacciones', 'Seminuevos'])
// ->whereYear('created_at', date('Y'))
// ->groupBy('departamento')
// ->get();

//Como podemos hacer un un input Select para seleccionar el mes y el año para mostrar los reportes por departamento departamentos y el total de reportes




const empleadosChartRef = ref(null);
const reportesChartRef = ref(null);
const redesSocialesChartRef = ref(null);

const totalEmpleados = computed(() =>
    props.empleadosPorRol.reduce((sum, item) => sum + item.total, 0)
);

const totalRep = computed(() =>
    props.reporteDepartamento.reduce((sum, item) => sum + item.total, 0)
);

onMounted(() => {
    createChart(empleadosChartRef.value, {
        type: 'doughnut',
        data: {
            labels: props.empleadosPorRol.map(item => item.rol),
            datasets: [{
                data: props.empleadosPorRol.map(item => item.total),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                ],
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: 'Distribución de Empleados por Rol'
                }
            }
        }
    });

    createChart(reportesChartRef.value, {
        type: 'bar',
        data: {
            labels: props.reporteDepartamento.map(item => item.departamento),

            datasets: [{
                label: 'Número de Reportes',
                data: props.reporteDepartamento.map(item => Math.floor(item.total)),
                backgroundColor: 'rgba(0, 30, 70, 0.7)',
                borderColor: 'rgba(0, 30, 70, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Reportes por Departamento'
                }
            }
        }
    });

    createChart(redesSocialesChartRef.value, {
        type: 'bar',
        data: {
            labels: props.redesSociales.map(item => item.redSocial),

            datasets: [{
                label: 'Número de Reportes por Red Social',
                data: props.redesSociales.map(item => item.total),
                backgroundColor: 'rgba(0, 30, 70, 0.7)',
                borderColor: 'rgba(0, 30, 70, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Reportes por Red Social'
                }
            }
        }
    });
});

function createChart(ctx, config) {
    return new Chart(ctx, config);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard {{ obtenerYearActual() }}</h1>
        </template>

        <div class="p-6 bg-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Empleados por Rol</h2>
                    <canvas ref="empleadosChartRef"></canvas>
                    <p class="text-center mt-4 text-lg font-medium">
                        Total de Empleados: {{ totalEmpleados }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Reportes por Departamento</h2>
                    <canvas ref="reportesChartRef"></canvas>
                    <p class="text-center mt-4 text-lg font-medium">
                        Total de Reportes: {{ totalRep }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Reportes por Red Social</h2>
                    <canvas ref="redesSocialesChartRef"></canvas>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.grid {
    display: grid;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

.bg-white {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
}

h2 {
    color: #2d3748;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

canvas {
    max-width: 100%;
    height: auto;
}
</style>
