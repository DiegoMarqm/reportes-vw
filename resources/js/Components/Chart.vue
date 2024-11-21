<script setup>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
    labels: Array,
    data: Array,
    title: String,
    type: {
        type: String,
        default: 'bar',
    },
    colors: {
        type: Array,
        default: () => ['rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)'],
    },
});

const chartRef = ref(null);
let chartInstance = null;

onMounted(() => {
    if (chartRef.value) {
        renderChart();
    }
});

watch(() => props.data, () => {
    renderChart();
});

function renderChart() {
    if (chartInstance) {
        chartInstance.destroy();
    }

    const ctx = chartRef.value.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, props.colors[0]);
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    chartInstance = new Chart(chartRef.value, {
        type: props.type,
        data: {
            labels: props.labels,
            datasets: [
                {
                    label: props.title,
                    data: props.data,
                    backgroundColor: props.type === 'bar' ? props.colors[0] : gradient,
                    borderColor: props.colors[1],
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: props.colors[1],
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold',
                        },
                        color: '#333',
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 16,
                        weight: 'bold',
                    },
                    bodyFont: {
                        size: 14,
                    },
                    padding: 12,
                    cornerRadius: 8,
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        font: {
                            size: 12,
                        },
                        color: '#666',
                    },
                },
                y: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                    },
                    ticks: {
                        font: {
                            size: 12,
                        },
                        color: '#666',
                    },
                },
            },
        },
    });
}
</script>

<template>
    <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
        <canvas ref="chartRef"></canvas>
    </div>
</template>

<style scoped>
.chart-container {
    transition: all 0.3s ease;
}

.chart-container:hover {
    transform: scale(1.02);
}
</style>
