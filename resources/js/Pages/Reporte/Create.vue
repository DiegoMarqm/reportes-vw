<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { CheckCircleIcon } from 'lucide-vue-next';

const props = defineProps({
    empleados: {
        type: Array,
        required: true
    }
});

const form = useForm({
    numFolio: '',
    departamento: '',
    calificacion: '',
    fechaQueja: '',
    fechaEntrega: '',
    fechaIngreso: '',
    formaDeteccion: '',
    redSocial: '',
    nomCliente: '',
    celularCliente: '',
    emailCliente: '',
    asesor: '',
    tipoModelo: '',
    placas: '',
    color: '',
    noOrden: '',
    vin: '',
    tecnico: '',
    reclamacion: '',
    tipoReclamacion: '',
    otroTipoReclamacion: '',


    causaRaiz: {
        personas: '',
        proceso: '',
        equipo: '',
        material: '',
        entorno: '',
        administracion: '',
    },

    medidas: [],

    procedeQueja: false,
    solucion: '',
    nombreCierre: '',
    fechaCierre: '',
    nombreSeguimiento: '',
    fechaSeguimiento: '',
    comentariosCliente: '',

});


const agregarMedida = () => {
    form.medidas.push({
        medida: '',
        responsable: '',
        fecha: ''
    });
};

const removeMedida = (index) => {
    form.medidas.splice(index, 1);
};

const showModal = ref(false);
const cargandoEnvio = ref(false);

const add = () => {

    cargandoEnvio.value = true;
    form.post(route('reporte.store'), {

        onSuccess: () => {
            form.reset();
            cargandoEnvio.value = false;
            showModal.value = true;
            console.log("showModal", showModal.value);

            console.log("Formulario enviado con éxito");

            setTimeout(() => {
                showModal.value = false;
                window.location.href = route('reporte.index');
            }, 2000);
        },

        onError: () => {
            console.log("Error al enviar el formulario");
            cargandoEnvio.value = false;
        },

    });
};

const limpiarFormulario = () => {
    form.reset();
    // window.location.reload();
};


const departamentoSeleccionado = ref('');

const empleadosFiltrados = ref([]);

watch(() => form.departamento, (newDepartamento) => {
    empleadosFiltrados.value = props.empleados.filter(empleado => empleado.departamento === newDepartamento);
});

const asesores = computed(() => {
    return empleadosFiltrados.value.filter(empleado => empleado.rol === 'Asesor');
});

const tecnicos = computed(() => {
    return empleadosFiltrados.value.filter(empleado => empleado.rol === 'Tecnico');
});

const asesoresTecnicos = computed(() => {
    return empleadosFiltrados.value.filter(empleado => empleado.rol === 'Asesor' || empleado.rol === 'Tecnico');
});


const gerentes = computed(() => {
    return empleadosFiltrados.value.filter(empleado => empleado.rol == 'Gerente');
})



console.log(asesores);



</script>

<template>

    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            Formulario Reportes
        </template>

        <div class="p-4 space-y-8 font-vwtext">
            <form @submit.prevent="add" class="bg-white rounded-lg shadow p-6 space-y-6 font-vwtext">

                <!-- Número de Folio -->
                <div>
                    <label for="numFolio" class="block text-gray-700">Número de Folio</label>
                    <input type="text" v-model="form.numFolio" id="numFolio" name="numFolio"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        placeholder="Num. Folio Reporte">
                    <span v-if="form.errors.numFolio" class="text-red-500 text-sm">{{ form.errors.numFolio }}</span>
                </div>

                <!-- Primera fila: Departamento y Calificación -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Campo Departamento -->
                    <div>
                        <label for="departamento" class="block text-gray-700">Departamento</label>
                        <select v-model="form.departamento" id="departamento" name="departamento"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="" disabled>Seleccione un departamento</option>
                            <option value="Ventas">Ventas</option>
                            <option value="Servicio">Servicio</option>
                            <option value="Refacciones">Refacciones</option>
                            <option value="Seminuevos">Seminuevos</option>
                        </select>
                        <span v-if="form.errors.departamento" class="text-red-500 text-sm">{{ form.errors.departamento
                            }}</span>
                    </div>

                    <!-- Campo Calificación -->
                    <div class="w-full sm:w-1/2">
                        <label for="calificacion" class="block text-gray-700">Calificación</label>
                        <input type="number" v-model="form.calificacion" id="calificacion" name="calificacion"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 placeholder-gray-500"
                            placeholder="Ingrese la calificación" min="1" max="5" step="1">
                        <span v-if="form.errors.calificacion" class="text-red-500 text-sm">{{ form.errors.calificacion
                            }}</span>
                    </div>
                </div>

                <!-- Segunda fila: Fechas -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Fecha de la queja -->
                    <div>
                        <label for="fechaQueja" class="block text-gray-700">Fecha de la queja</label>
                        <input type="date" v-model="form.fechaQueja" id="fechaQueja" name="fechaQueja"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span v-if="form.errors.fechaQueja" class="text-red-500 text-sm">{{ form.errors.fechaQueja
                            }}</span>
                    </div>

                    <!-- Fecha de entrega de la unidad -->
                    <div>
                        <label for="fechaEntrega" class="block text-gray-700">Fecha de entrega de la unidad</label>
                        <input type="date" v-model="form.fechaEntrega" id="fechaEntrega" name="fechaEntrega"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span v-if="form.errors.fechaEntrega" class="text-red-500 text-sm">{{ form.errors.fechaEntrega
                            }}</span>
                    </div>

                    <!-- Fecha de ingreso -->
                    <div>
                        <div class="flex items-center">
                            <label for="fechaIngreso" class="block text-gray-700 mr-2">Fecha de ingreso</label>
                            <small class="text-gray-500 font-vwtext font-bold">(Solo si aplica)</small>
                            <!-- Texto alineado al lado del label -->
                        </div>
                        <input type="date" v-model="form.fechaIngreso" id="fechaIngreso" name="fechaIngreso"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span v-if="form.errors.fechaIngreso" class="text-red-500 text-sm">{{ form.errors.fechaIngreso
                            }}</span>
                    </div>
                </div>

                <!-- Forma que se detectó la queja -->
                <div class="mb-4">
                    <label for="formaDeteccion" class="block text-gray-700">Forma que se detectó la queja</label>

                    <div class="flex flex-col lg:flex-row lg:space-x-4">
                        <!-- Select para elegir cómo se detectó la queja -->
                        <select v-model="form.formaDeteccion" id="formaDeteccion" name="formaDeteccion"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 lg:w-1/2">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="Presencial">Presencial</option>
                            <option value="HotAlert">HotAlert</option>
                            <option value="Redes sociales">Redes sociales</option>
                            <option value="Llamada de seguimiento">Llamada de seguimiento</option>
                            <option value="E-mail">E-mail</option>
                            <option value="Profeco">Profeco</option>
                        </select>

                        <!-- Campo adicional solo si la opción es "Redes sociales" -->
                        <div v-if="form.formaDeteccion === 'Redes sociales'" class="mt-4 lg:mt-0 lg:w-1/2">
                            <label for="redSocial" class="block text-gray-700">Especifique la red social</label>
                            <input type="text" v-model="form.redSocial" id="redSocial" name="redSocial"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especifique la red social">
                        </div>
                    </div>

                    <!-- Mostrar error si lo hay -->
                    <span v-if="form.errors.formaDeteccion || form.errors.redSocial" class="text-red-500 text-sm">
                        {{ form.errors.formaDeteccion || form.errors.redSocial }}
                    </span>
                </div>

                <!-- Datos del Cliente -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-vwheadbold">Datos del Cliente</label>

                    <div class="flex flex-col lg:flex-row lg:space-x-4 mt-2">
                        <!-- Nombre del cliente -->
                        <div class="lg:w-1/3">
                            <label for="nombreCliente" class="block text-gray-700">Nombre del Cliente</label>
                            <input type="text" v-model="form.nomCliente" id="nombreCliente" name="nombreCliente"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Nombre completo">
                        </div>

                        <!-- Celular -->
                        <div class="lg:w-1/3 mt-4 lg:mt-0">
                            <label for="celularCliente" class="block text-gray-700">Celular</label>
                            <input type="tel" v-model="form.celularCliente" id="celularCliente" name="celularCliente"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="10 dígitos" pattern="[0-9]{10}">
                        </div>

                        <!-- E-mail -->
                        <div class="lg:w-1/3 mt-4 lg:mt-0">
                            <label for="emailCliente" class="block text-gray-700">E-mail</label>
                            <input type="email" v-model="form.emailCliente" id="emailCliente" name="emailCliente"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <!-- Mostrar errores si los hay -->
                    <span v-if="form.errors.nombreCliente || form.errors.celularCliente || form.errors.emailCliente"
                        class="text-red-500 text-sm mt-2">
                        {{ form.errors.nombreCliente || form.errors.celularCliente || form.errors.emailCliente }}
                    </span>
                </div>


                <!-- Datos de Identificación -->
                <div class="mb-4">
                    <label class="block text-gray-700">Datos de Identificación</label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <!-- Asesor/Ejecutivo -->
                        <div>
                            <label for="asesor" class="block text-gray-700">Asesor/Ejecutivo</label>
                            <select v-model="form.asesor" id="asesor" name="asesor"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Seleccionar...</option>
                                <option v-for="empleado in asesores" :key="empleado.id" :value="empleado.nombre">{{
                                    empleado.nombre }}</option>
                            </select>
                        </div>

                        <!-- Tipo/Modelo -->
                        <div>
                            <label for="tipoModelo" class="block text-gray-700">Tipo/Modelo</label>
                            <input type="text" v-model="form.tipoModelo" id="tipoModelo" name="tipoModelo"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Ej. Jetta 2020">
                        </div>

                        <!-- Placas -->
                        <div>
                            <label for="placas" class="block text-gray-700">Placas</label>
                            <input type="text" v-model="form.placas" id="placas" name="placas"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="ABC-1234">
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-gray-700">Color</label>
                            <input type="text" v-model="form.color" id="color" name="color"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Ej. Blanco">
                        </div>

                        <!-- No. Orden -->
                        <div>
                            <label for="noOrden" class="block text-gray-700">No. Orden</label>
                            <input type="text" v-model="form.noOrden" id="noOrden" name="noOrden"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="123456">
                        </div>

                        <!-- No. de VIN -->
                        <div>
                            <label for="vin" class="block text-gray-700">No. de VIN</label>
                            <input type="text" v-model="form.vin" id="vin" name="vin"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="1HGCM82633A123456">
                        </div>

                        <!-- Técnico -->
                        <div>
                            <label for="tecnico" class="block text-gray-700">Técnico</label>
                            <select v-model="form.tecnico" id="tecnico" name="tecnico"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Seleccionar...</option>
                                <option v-for="empleado in tecnicos" :key="empleado.id" :value="empleado.nombre">{{
                                    empleado.nombre }}</option>
                            </select>
                        </div>
                    </div>


                    <!-- Sección de Reclamación -->
                    <div class="my-8">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-2">
                            <!-- Reclamación (Textarea) -->
                            <div>
                                <label for="reclamacion" class="block text-gray-700">Reclamación (Describe la
                                    reclamación del
                                    cliente)</label>
                                <textarea v-model="form.reclamacion" id="reclamacion" name="reclamacion"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    rows="5" placeholder="Describe la reclamación del cliente"></textarea>
                            </div>

                            <!-- Tipo de Reclamación -->
                            <div>
                                <label for="tipoReclamacion" class="block text-gray-700">Tipo de reclamación</label>
                                <select v-model="form.tipoReclamacion" id="tipoReclamacion" name="tipoReclamacion"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="handleTipoReclamacionChange">
                                    <option value="" disabled selected>Seleccionar...</option>
                                    <option value="Reparacion">Reparación</option>
                                    <option value="Seguimiento">Seguimiento</option>
                                    <option value="Falla Refacciones">Falla Refacciones</option>
                                    <option value="Tiempos">Tiempos</option>
                                    <option value="Trabajo que realiza">Trabajo que realiza</option>
                                    <option value="Daño/Perdida">Daño/Pérdida</option>
                                    <option value="Limpieza">Limpieza</option>
                                    <option value="Explicacion">Explicación</option>
                                    <option value="Citas">Citas</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <!-- TextField habilitado solo si se selecciona "Otro" -->
                                <div v-if="form.tipoReclamacion === 'Otro'" class="mt-4">
                                    <label for="otroTipoReclamacion" class="block text-gray-700">Especificar otro tipo
                                        de
                                        reclamación</label>
                                    <input type="text" v-model="form.otroTipoReclamacion" id="otroTipoReclamacion"
                                        name="otroTipoReclamacion"
                                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        placeholder="Especificar otro tipo de reclamación">
                                </div>
                            </div>
                        </div>

                        <!-- Mostrar errores si los hay -->
                        <span
                            v-if="form.errors.reclamacion || form.errors.tipoReclamacion || form.errors.otroTipoReclamacion"
                            class="text-red-500 text-sm mt-2">
                            {{ form.errors.reclamacion || form.errors.tipoReclamacion || form.errors.otroTipoReclamacion
                            }}
                        </span>
                    </div>


                    <!-- Mostrar errores si los hay -->
                    <span
                        v-if="form.errors.asesor || form.errors.tipoModelo || form.errors.placas || form.errors.color || form.errors.noOrden || form.errors.vin || form.errors.tecnico"
                        class="text-red-500 text-sm mt-2">
                        {{ form.errors.asesor || form.errors.tipoModelo || form.errors.placas || form.errors.color ||
                            form.errors.noOrden || form.errors.vin || form.errors.tecnico }}
                    </span>
                </div>


                <!-- Sección de Causa Raíz de la Queja -->
                <div class="mb-4">
                    <label class="block text-gray-700">Causa Raíz de la Queja</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                        <!-- Personas -->
                        <div>
                            <label for="personas" class="block text-gray-700">Personas</label>
                            <input type="text" v-model="form.causaRaiz.personas" id="personas" name="personas"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especificar personas">
                        </div>

                        <!-- Proceso -->
                        <div>
                            <label for="proceso" class="block text-gray-700">Proceso</label>
                            <input type="text" v-model="form.causaRaiz.proceso" id="proceso" name="proceso"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especificar proceso">
                        </div>

                        <!-- Equipo -->
                        <div>
                            <label for="equipo" class="block text-gray-700">Equipo</label>
                            <input type="text" v-model="form.causaRaiz.equipo" id="equipo" name="equipo"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especificar equipo">
                        </div>

                        <!-- Material -->
                        <div>
                            <label for="material" class="block text-gray-700">Material</label>
                            <input type="text" v-model="form.causaRaiz.material" id="material" name="material"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especificar material">
                        </div>

                        <!-- Entorno -->
                        <div>
                            <label for="entorno" class="block text-gray-700">Entorno</label>
                            <input type="text" v-model="form.causaRaiz.entorno" id="entorno" name="entorno"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especificar entorno">
                        </div>

                        <!-- Administración -->
                        <div>
                            <label for="administracion" class="block text-gray-700">Administración</label>
                            <input type="text" v-model="form.causaRaiz.administracion" id="administracion"
                                name="administracion"
                                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Especificar administración">
                        </div>
                    </div>
                </div>

                <!-- Sección de Medidas a Tomar -->
                <div class="mb-4">
                    <label class="block text-gray-700">Medidas a Tomar</label>

                    <!-- Tabla de Medidas -->
                    <div class="overflow-x-auto mt-2">
                        <table class="min-w-full border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Medida</th>
                                    <th class="border border-gray-300 px-4 py-2">Responsable</th>
                                    <th class="border border-gray-300 px-4 py-2">Fecha</th>
                                    <th class="border border-gray-300 px-2 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(medida, index) in form.medidas" :key="index">
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="text" v-model="medida.medida"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            placeholder="Especificar medida">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <select v-model="medida.responsable"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="" disabled selected>Seleccionar...</option>
                                            <option v-for="empleado in asesoresTecnicos" :key="empleado.id"
                                                :value="empleado.nombre">{{
                                                    empleado.nombre }}</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <input type="date" v-model="medida.fecha"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <button @click="removeMedida(index)" class="text-red-500">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button @click="agregarMedida" class="mt-2 bg-blue-500 text-white rounded-md px-4 py-2">Agregar
                            Medida</button>
                    </div>


                </div>

                <!-- Sección: Procede la Queja -->
                <div class="mb-4 text-center">
                    <label class="block text-gray-700">
                        De acuerdo a este formato y a la reclamación aquí descrita. ¿Procede la queja?
                    </label>
                    <div class="flex justify-center items-center mt-2">
                        <div class="mr-4">
                            <input type="radio" id="procedeSi" name="procedeQueja" :value="true"
                                v-model="form.procedeQueja" class="mr-1" />
                            <label for="procedeSi" class="text-gray-700">Sí</label>
                        </div>
                        <div>
                            <input type="radio" id="procedeNo" name="procedeQueja" :value="false"
                                v-model="form.procedeQueja" class="mr-1" />
                            <label for="procedeNo" class="text-gray-700">No</label>
                        </div>
                    </div>
                    <!-- Mostrar errores si los hay -->
                    <span v-if="form.errors.procedeQueja" class="text-red-500 text-sm mt-2">
                        {{ form.errors.procedeQueja }}
                    </span>
                </div>

                <div v-if="form.procedeQueja">
                    <!-- Sección: ¿Qué solución se le dio al cliente? -->
                    <div class="mb-4">
                        <label class="block text-gray-700">¿Qué solución se le dio al cliente?</label>
                        <textarea v-model="form.solucion" id="solucion" name="solucion" rows="4" maxlength="1200"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Describe la solución dada al cliente (máximo 200 palabras)"></textarea>
                        <span class="text-gray-500 text-sm">
                            (Máximo 200 palabras)
                        </span>
                        <!-- Mostrar errores si los hay -->
                        <span v-if="form.errors.solucion" class="text-red-500 text-sm mt-2">
                            {{ form.errors.solucion }}
                        </span>
                    </div>


                    <!-- Sección: Personal que cerró la reclamación -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-center">Personal que cerró la reclamación</label>

                        <div class="flex flex-col lg:flex-row lg:justify-center lg:space-x-4 mt-2">
                            <!-- Nombre -->
                            <div class="lg:w-1/2">
                                <label for="nombreCierre" class="block text-gray-700">Nombre</label>
                                <select v-model="form.nombreCierre" id="nombreCierre" name="nombreCierre"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" disabled selected>Seleccionar...</option>
                                    <!-- Ciclo para obtener los empleados -->
                                    <option v-for="empleado in gerentes" :key="empleado.id" :value="empleado.nombre">
                                        {{ empleado.nombre }}
                                    </option>
                                </select>
                            </div>

                            <!-- Fecha -->
                            <div class="lg:w-1/2 mt-4 lg:mt-0">
                                <label for="fechaCierre" class="block text-gray-700">Fecha</label>
                                <input type="date" v-model="form.fechaCierre" id="fechaCierre" name="fechaCierre"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <!-- Mostrar errores si los hay -->
                        <span v-if="form.errors.nombreCierre || form.errors.fechaCierre"
                            class="text-red-500 text-sm mt-2">
                            {{ form.errors.nombreCierre || form.errors.fechaCierre }}
                        </span>
                    </div>

                    <!-- Sección: Personal que realizó contacto de seguimiento -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-center">Personal que realizó contacto de
                            seguimiento</label>

                        <div class="flex flex-col lg:flex-row lg:justify-center lg:space-x-4 mt-2">
                            <!-- Nombre -->
                            <div class="lg:w-1/2">
                                <label for="nombreSeguimiento" class="block text-gray-700">Nombre</label>
                                <select v-model="form.nombreSeguimiento" id="nombreSeguimiento" name="nombreSeguimiento"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" disabled selected>Seleccionar...</option>
                                    <!-- Ciclo para obtener los empleados -->
                                    <option v-for="empleado in gerentes" :key="empleado.id" :value="empleado.nombre">
                                        {{ empleado.nombre }}
                                    </option>
                                </select>
                            </div>

                            <!-- Fecha -->
                            <div class="lg:w-1/2 mt-4 lg:mt-0">
                                <label for="fechaSeguimiento" class="block text-gray-700">Fecha</label>
                                <input type="date" v-model="form.fechaSeguimiento" id="fechaSeguimiento"
                                    name="fechaSeguimiento"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>

                        <!-- Mostrar errores si los hay -->
                        <span v-if="form.errors.nombreSeguimiento || form.errors.fechaSeguimiento"
                            class="text-red-500 text-sm mt-2">
                            {{ form.errors.nombreSeguimiento || form.errors.fechaSeguimiento }}
                        </span>
                    </div>

                    <!-- Sección: Comentarios del cliente -->
                    <div class="mb-4">
                        <label class="block text-gray-700">Comentarios del cliente</label>
                        <textarea v-model="form.comentariosCliente" id="comentariosCliente" name="comentariosCliente"
                            rows="4"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Escriba los comentarios del cliente aquí..."></textarea>

                        <!-- Mostrar errores si los hay -->
                        <span v-if="form.errors.comentariosCliente" class="text-red-500 text-sm mt-2">
                            {{ form.errors.comentariosCliente }}
                        </span>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end">

                    <Link :href="route('reporte.index')"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2">Cancelar
                    </Link>

                    <button type="submit" class="px-4 py-2 bg-sky-500 text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors duration-300 flex items-center" :disabled="cargandoEnvio">
                        <span v-if="cargandoEnvio" class="mr-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        {{ cargandoEnvio ? 'Enviando...' : 'Enviar' }}
                    </button>
                </div>
            </form>
            <!-- Boton para limpiar el fomulario -->
            <button @click="limpiarFormulario()"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">Limpiar
                formulario</button>

        </div>

        <!-- Modal de éxito -->
        <transition enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 transform scale-90" enter-to-class="opacity-100 transform scale-100"
            leave-active-class="transition ease-in duration-300" leave-from-class="opacity-100 transform scale-100"
            leave-to-class="opacity-0 transform scale-90">
            <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="bg-white rounded-lg p-8 shadow-xl z-10 max-w-md w-full m-4">
                    <div class="flex items-center justify-center mb-4 text-green-600">
                        <CheckCircleIcon size="48" class="animate-bounce" />
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-center text-gray-900">¡Éxito!</h3>
                    <p class="text-gray-700 text-center">El reporte se ha añadido.</p>
                </div>
            </div>
        </transition>

    </AuthenticatedLayout>
</template>

<style scoped>


@keyframes bounce {

0%,
100% {
    transform: translateY(-25%);
    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
}

50% {
    transform: translateY(0);
    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
}
}

.animate-bounce {
animation: bounce 1s infinite;
}
</style>
