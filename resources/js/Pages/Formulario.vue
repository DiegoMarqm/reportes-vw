<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const isLoaded = ref(false);

const submitForm = () => {
    // Lógica para manejar el envío del formulario
    console.log('Formulario enviado')
}

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});
</script>

<template>

    <Head title="Formulario" />

    <AuthenticatedLayout>
        <template #header>
            <!-- Header content if needed -->
        </template>

        <div class="py-0 sm:py-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                        <div :class="['transition-all duration-1000 ease-out transform',
                            isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4']">
                            <div class="flex flex-col sm:flex-row items-center justify-between mb-6 sm:mb-8">
                                <h2
                                    class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-4 sm:mb-0 text-center sm:text-left">
                                    Registro de quejas
                                </h2>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Volkswagen_logo_2019.svg"
                                    alt="Volkswagen Logo" class="h-8 sm:h-10" />


                            </div>

                            <form class="space-y-6 sm:space-y-8" @submit.prevent="submitForm">
                                <!-- Datos-->
                                <div class="flex flex-col space-y-6 sm:space-y-0 sm:flex-row sm:space-x-4">
                                    <!-- Sección de Departamento -->
                                    <div class="w-full sm:w-3/4 border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Departamento</h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="departamento" value="ventas"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Ventas</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="departamento" value="servicio"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Servicio</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="departamento" value="refacciones"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Refacciones</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="departamento" value="seminuevo"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Seminuevo</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Sección de Calificación -->
                                    <div class="w-full sm:w-1/4 border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Calificación</h3>
                                        <div class="flex justify-center">
                                            <input type="text" name="calificacion"
                                                class="form-input w-full px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                placeholder="Calificación" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha de queja -->
                                <div class="flex flex-col space-y-6 sm:space-y-0 sm:flex-row sm:space-x-4">
                                    <!-- Sección de fecha de la queja -->
                                    <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4 ">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4">Fecha de la queja:</h3>
                                            <input type="text" name="fechaqueja"
                                                class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                placeholder="dd/mm/aa" />
                                        </div>
                                    </div>
                                    <!-- Sección de fecha entrega -->
                                    <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4">Fecha de la entrega de la
                                                unidad
                                            </h3>
                                            <input type="text" name="fechaentrega"
                                                class="form-input w-full px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                placeholder="" />
                                        </div>
                                    </div>
                                    <!-- Sección de ingreso -->
                                    <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4">Fecha de ingreso</h3>
                                            <input type="text" name="fechaingreso"
                                                class="form-input w-full px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Forma que se detecto la queja -->
                                <div class="flex flex-col space-y-6 sm:space-y-0 sm:flex-row sm:space-x-4">
                                    <!-- Sección de quejas -->
                                    <div class="w-full sm:w-4/4 border border-gray-200 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Forma en la que se detecto la
                                            queja:
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="queja" value="presencial"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Presencial</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="queja" value="hotalert"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Hot Alert</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="queja" value="redes"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Redes sociales</span>
                                                <input type="text" name="nomcliente"
                                                    class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                    placeholder="" />
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="queja" value="llamada"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Llamada de seguimiento</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="queja" value="correo"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">E-Mail</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="queja" value="profeco"
                                                    class="form-radio text-blue-600" />
                                                <span class="ml-2">Profeco</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos del cliente -->
                                <div class="w-full sm:w-4/4  border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del cliente</h3>
                                    <div class="flex flex-col space-y-6 sm:space-y-0 sm:flex-row sm:space-x-4 p-4">
                                        <div class="w-full sm:w-2/3 border border-gray-200 rounded-lg p-4">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Nombre del cliente
                                                </h3>
                                                <input type="text" name="nomcliente"
                                                    class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                        <!-- Sección de celular -->
                                        <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Celular</h3>
                                                <input type="text" name="celular"
                                                    class="form-input w-full px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sección de correo -->
                                    <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4">E-Mail</h3>
                                            <input type="text" name="correocliente"
                                                class="form-input w-full px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                placeholder="" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos de identificación -->
                                <div class="w-full sm:w-4/4 border border-gray-200 rounded-lg p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Datos de identificación</h3>
                                    <div class="w-full sm:w-3/3 border border-gray-200 rounded-lg p-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <h3 class="text-sm font-medium text-gray-900 mb-4">Asesor / Ejecutivo</h3>
                                            <select>
                                                <option value="">Opcion 1</option>
                                                <option value="">Opcion 2</option>
                                                <option value="">Opciom 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex flex-col space-y-6 sm:space-y-0 sm:flex-row sm:space-x-4">
                                        <!-- Sección de tipo y No. de orden -->
                                        <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <row class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Tipo / Modelo</h3>
                                                    <input type="text" name="modelo"
                                                        class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                        placeholder="" />
                                                    <h3 class="text-sm font-medium text-gray-900 mb-4">No. de Orden</h3>
                                                    <input type="text" name="orden"
                                                        class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                        placeholder="" />
                                                </row>
                                            </div>
                                        </div>
                                        <!-- Sección de Placas y VIN -->
                                        <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4 ">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <row class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Placas</h3>
                                                    <input type="text" name="placas"
                                                        class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                        placeholder="" />
                                                    <h3 class="text-sm font-medium text-gray-900 mb-4">No. de VIN</h3>
                                                    <input type="text" name="vin"
                                                        class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                        placeholder="" />
                                                </row>
                                            </div>
                                        </div>
                                        <!-- Sección de tipo y No. de orden -->
                                        <div class="w-full sm:w-1/3 border border-gray-200 rounded-lg p-4 ">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <row class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Color</h3>
                                                    <input type="text" name="color"
                                                        class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                        placeholder="" />
                                                    <h3 class="text-sm font-medium text-gray-900 mb-4">Técnico</h3>
                                                    <input type="text" name="tecnico"
                                                        class="form-input w-auto px-3 py-2 bg-blue-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-center placeholder-center"
                                                        placeholder="" />
                                                </row>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex justify-center">
                                    <button type="submit"
                                        class="px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -20px, 0);
    }

    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.animate-fade-in-down {
    animation: fadeInDown 0.5s ease-out;
}

.placeholder-center::placeholder {
    text-align: center;
}
</style>
