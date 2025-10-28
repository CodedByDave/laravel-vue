<script setup>
import { ref } from "vue";
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Form, Head, Link, useForm } from "@inertiajs/vue3";
import { Presentation } from "lucide-vue-next";
import Swal from "sweetalert2";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route("login"),{
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'You have successfully logged in.',
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: true,
            }).then(() => {
                window.location.ref = route('dashboard');
            });
        },
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="w-full flex justify-center mt-10">
            <div class="w-full max-w-md rounded-lg p-6">

                <h2 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-white">
                    Log in
                </h2>
                <p class="text-2l text-center mb-6 text-gray-800 dark:text-white">
                    Please enter your credentials to access your account.
                </p>

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <!-- Email -->
                    <div>
                        <InputLabel for="email" value="Email Address" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            autofocus
                            placeholder="Enter your email address"

                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password with toggle -->
                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />

                        <div class="relative">
                            <TextInput
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                class="mt-1 block w-full pr-10"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                            />

                            <!-- Eye Icon -->
                            <svg
                                v-if="!showPassword"
                                @click="showPassword = true"
                                xmlns="http://www.w3.org/2000/svg"
                                class="absolute right-3 top-3 w-5 h-5 text-gray-500 cursor-pointer"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                            <!-- Eye Slash Icon -->
                            <svg
                                v-else
                                @click="showPassword = false"
                                xmlns="http://www.w3.org/2000/svg"
                                class="absolute right-3 top-3 w-5 h-5 text-gray-500 cursor-pointer"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3.98 8.223A10.477 10.477 0 001.934 12c1.466 3.993 5.332 7 10.066 7 1.688 0 3.289-.38 4.713-1.057M6.228 6.228A10.45 10.45 0 0112 5c4.66 0 8.533 3.017 9.992 7.028a10.523 10.523 0 01-4.132 5.225M6.228 6.228L3 3m3.228 3.228l12.544 12.544" />
                            </svg>
                        </div>

                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="mt-4 flex justify-between items-center">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-gray-600 underline hover:text-gray-900 dark:text-gray-400"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <!-- Button -->
                    <div class="mt-6">
                        <PrimaryButton
                            class="w-full justify-center py-3 px-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Login
                        </PrimaryButton>
                    </div>

                    <!-- Register Link -->
                    <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                        Don’t have an account?
                        <Link :href="route('register')" class="underline hover:text-gray-900">
                            Register here
                        </Link>
                    </p>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
