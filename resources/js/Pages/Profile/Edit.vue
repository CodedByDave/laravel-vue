<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const activeTab = ref("profile");
</script>

<template>
    <Head title="Settings" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold">Settings</h2>
        </template>

        <div>
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Settings
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Manage your profile and account settings
            </p>
        </div>

        <div class="py-6 max-w-6xl mx-auto flex gap-8">
            <!-- LEFT SIDEBAR -->
            <aside class="w-64 text-white rounded-lg p-4">
                <button
                    @click="activeTab = 'profile'"
                    class="w-full text-left px-3 py-2 rounded-lg"
                    :class="
                        activeTab === 'profile'
                            ? 'bg-gray-700'
                            : 'hover:bg-gray-800'
                    "
                >
                    Profile
                </button>

                <button
                    @click="activeTab = 'password'"
                    class="w-full text-left px-3 py-2 rounded-lg"
                    :class="
                        activeTab === 'password'
                            ? 'bg-gray-700'
                            : 'hover:bg-gray-800'
                    "
                >
                    Password
                </button>

                <button
                    @click="activeTab = 'delete'"
                    class="w-full text-left px-3 py-2 rounded-lg"
                    :class="
                        activeTab === 'delete'
                            ? 'bg-gray-700'
                            : 'hover:bg-gray-800'
                    "
                >
                    Delete Account
                </button>
            </aside>

            <!-- RIGHT CONTENT -->
            <div class="flex-1 shadow rounded-lg p-6">
                <UpdateProfileInformationForm
                    v-if="activeTab === 'profile'"
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />

                <UpdatePasswordForm v-if="activeTab === 'password'" />

                <DeleteUserForm v-if="activeTab === 'delete'" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
