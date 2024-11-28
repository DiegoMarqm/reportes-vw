<script setup>
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { onMounted } from "vue";

const { props } = usePage();

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}

onMounted(() => {
    if (props.auth.user) {
        window.location.href = route('dashboard');
    }else{
        localStorage.removeItem('splashShown');
    }

});

</script>

<template>
    <GuestLayout>

        <Head title="Login"></Head>
        <div class="flex flex-col overflow-y-auto md:flex-row font-vwtext">
            <div class="h-44 md:h-auto md:w-1/2">
                <img aria-hidden="true" class="object-cover w-full h-full " src="/images/loginvw.jpg" alt="Office" />
			</div>

            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700 font-vwheadbold">Inicia Sesión</h1>

                    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <InputLabel for="email" value="Usuario" />
                            <TextInput id="email" type="text" class="block w-full mt-1" v-model="form.email"
                                autofocus autocomplete="username" />
                            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password" value="Contraseña" />
                            <TextInput id="password" type="password" class="block w-full mt-1" v-model="form.password"
                                required autocomplete="current-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>


                        <div class="flex items-center justify-center mt-4">
                            <!-- <Link v-if="canResetPassword" :href="route('password.request')"
                                class="text-sm text-gray-600 underline  hover:text-gray-900">
                            Forgot your password?
                            </Link> -->

                            <PrimaryButton class="ml-4 font-vwtext" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Entrar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>

</template>
