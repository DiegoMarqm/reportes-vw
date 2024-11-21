<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import Chart from '@/Components/Chart.vue';
import { FileText, PercentIcon, Star, Clock } from 'lucide-vue-next';

const props = defineProps({
    totalReportes: Number,
    porcentajeProcedentes: Number,
    calificacionPromedio: Number,
    tiempoResolucion: Number,
    quejasPorMes: Array,
    calificacionesPorMes: Array,
    cierrePorMes: Array,
});

const quejasPorMesComputed = computed(() => props.quejasPorMes?.length ? props.quejasPorMes : []);
const calificacionesPorMesComputed = computed(() => props.calificacionesPorMes?.length ? props.calificacionesPorMes : []);
const cierrePorMesComputed = computed(() => props.cierrePorMes?.length ? props.cierrePorMes : []);

const obtenerYearActual = () => new Date().getFullYear();

const cardData = [
    { title: 'Total de Reportes', value: props.totalReportes, icon: FileText, color: 'bg-blue-500', textColor: 'text-blue-600' },
    { title: 'Porcentaje de quejas que procedieron', value: `${props.porcentajeProcedentes}%`, icon: PercentIcon, color: 'bg-green-500', textColor: 'text-green-600' },
    { title: 'Calificación Promedio quejas ', value: props.calificacionPromedio.toFixed(1), icon: Star, color: 'bg-yellow-500', textColor: 'text-yellow-600' },
    { title: 'Tiempo Promedio de Resolución de una queja', value: `${props.tiempoResolucion} días`, icon: Clock, color: 'bg-purple-500', textColor: 'text-purple-600' },
];
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout class="font-vwtext">
        <template #header>
            <h1 class="text-3xl font-vwheadbold text-gray-800">Dashboard {{ obtenerYearActual() }}</h1>
        </template>

        <div class="p-6 bg-gray-100">
            <div class="dashboard-info mb-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-700 font-vwheadbold">Información General</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="(card, index) in cardData" :key="index"
                        class="card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-500 mb-2 h-10 overflow-hidden text-center"
                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-clamp: 2;">{{
                                card.title
                                }}</h3>
                            <div class="flex items-center justify-center h-10">
                                <span :class="[card.textColor, 'text-2xl font-bold truncate text-center mr-2']">{{ card.value }}</span>
                                <div :class="[card.color, 'rounded-full p-2 text-white']">
                                    <component :is="card.icon" size="20" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-charts">
                <!-- <h2 class="text-2xl font-bold mb-6 text-gray-700">Gráficos de Tendencias</h2> -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <Chart
                            :labels="['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']"
                            :data="quejasPorMesComputed" title="Quejas totales por mes" type="bar"
                            :colors="['rgba(59, 130, 246, 0.5)', 'rgba(59, 130, 246, 1)']" />
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <Chart
                            :labels="['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']"
                            :data="calificacionesPorMesComputed" title="Promedio de calificaciones por mes" type="line"
                            :colors="['rgba(245, 158, 11, 0.5)', 'rgba(245, 158, 11, 1)']" />
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <Chart
                            :labels="['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']"
                            :data="cierrePorMesComputed" title="Tasa de cierres por mes" type="line"
                            :colors="['rgba(16, 185, 129, 0.5)', 'rgba(16, 185, 129, 1)']" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>
