<template>
    <div>
      <h1>Gráfica de Empleados por Rol</h1>
      <div>
        <canvas id="empleados-chart"></canvas>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import { Chart } from 'chart.js';

  const props = defineProps({
    empleados: {
      type: Object
    }
  });

  const chart = ref(null);

  onMounted(() => {
    const labels = Object.keys(props.empleados);
    const data = Object.values(props.empleados).map(group => group.length);

    const ctx = document.getElementById('empleados-chart').getContext('2d');
    chart.value = new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Empleados por Rol',
          data,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgb(255, 99, 132)',
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
  </script>
