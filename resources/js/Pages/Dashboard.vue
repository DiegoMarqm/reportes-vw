<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
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
