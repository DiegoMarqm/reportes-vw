<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, } from '@inertiajs/vue3';
import { ref } from 'vue';



</script>

<template>
    <Head title="Formulario para personal" />
    <AuthenticatedLayout>
        <template #header>
            Formulario
        </template>
        <!-- <div class="p-4 bg-white rounded-lg shadow-xs">
            Formulario para el personal
        </div> -->
        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div v-for="role in roles" :key="role">
                <h2>{{ role }}</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2">ID</th>
                            <th class="py-2">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in data[role]" :key="item.id">
                            <td class="border px-4 py-2">{{ item.id }}</td>
                            <td class="border px-4 py-2">{{ item.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
