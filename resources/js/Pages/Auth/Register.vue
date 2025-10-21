<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirm = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="max-w-md mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-white">
                Create Account
            </h2>

            <form @submit.prevent="submit">
                <!-- Name -->
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter your name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <InputLabel for="email" value="Email Address" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="Enter your email"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <div class="relative">
                        <TextInput
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            class="mt-1 block w-full pr-10"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            placeholder="Enter your password"
                        />

                        <!-- Eye Icon (Same as Login.vue) -->
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

                <!-- Confirm Password -->
                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />
                    <div class="relative">
                        <TextInput
                            :type="showPasswordConfirm ? 'text' : 'password'"
                            id="password_confirmation"
                            class="mt-1 block w-full pr-10"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm your password"
                        />

                        <!-- Eye Icon (Same as Login.vue) -->
                        <svg
                            v-if="!showPasswordConfirm"
                            @click="showPasswordConfirm = true"
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute right-3 top-3 w-5 h-5 text-gray-500 cursor-pointer"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <svg
                            v-else
                            @click="showPasswordConfirm = false"
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute right-3 top-3 w-5 h-5 text-gray-500 cursor-pointer"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3.98 8.223A10.477 10.477 0 001.934 12c1.466 3.993 5.332 7 10.066 7 1.688 0 3.289-.38 4.713-1.057M6.228 6.228A10.45 10.45 0 0112 5c4.66 0 8.533 3.017 9.992 7.028a10.523 10.523 0 01-4.132 5.225M6.228 6.228L3 3m3.228 3.228l12.544 12.544" />
                        </svg>
                    </div>
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <PrimaryButton
                    class="w-full justify-center mt-6 py-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>

                <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <Link :href="route('login')" class="underline hover:text-gray-900">
                        Log in
                    </Link>
                </p>
            </form>
        </div>
    </GuestLayout>
</template>
