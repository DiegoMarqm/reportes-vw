<template>
  <button :type="type" class="rounded-lg border border-transparent bg-purple-600 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:stroke-[rgb(0,176,240)] focus:outline-none focus:ring active:bg-purple-600" :style="{backgroundColor: 'rgb(0, 30, 80)'}">
    <slot/>
  </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<style scoped>

.active-bg {
  background-color: rgb(0, 30, 128); /* Color RGB para el estado activo */
}
</style>
