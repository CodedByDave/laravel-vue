<script setup>
import Sidebar from "@/Components/Sidebar.vue";
import { useTheme } from "@/Composables/useTheme";

const { theme, toggleTheme } = useTheme();
</script>

<template>
    <div
        class="flex bg-gray-50 dark:bg-gray-950 min-h-screen text-gray-900 dark:text-gray-200 transition-colors duration-500"
    >
        <Sidebar />

        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header
                class="h-14 border-b border-gray-300 dark:border-gray-800 flex items-center justify-between px-6 bg-white dark:bg-gray-900 transition-colors duration-500"
            >
                <h2 class="text-xl font-semibold">
                    <slot name="title" />
                </h2>

                <!-- Day/Night Toggle -->
                <button
                    @click="toggleTheme"
                    class="relative w-16 h-8 rounded-full transition-all duration-300 ease-in-out shadow-inner"
                    :class="
                        theme === 'dark'
                            ? 'bg-gray-700'
                            : 'bg-white'
                    "
                >
                    <!-- Toggle Circle with Icon -->
                    <div
                        class="absolute top-0.5 h-7 w-7 rounded-full flex items-center justify-center transition-all duration-300 ease-in-out shadow-md"
                        :class="theme === 'dark' ? 'left-0.5 bg-blue-600' : 'left-[calc(100%-1.875rem)] bg-blue-500'"
                    >
                        <svg
                            v-if="theme === 'dark'"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="white"
                            class="w-4 h-4"
                        >
                            <path d="M21.752 15.002A9.718 9.718 0 0112.004 21c-5.385 0-9.75-4.365-9.75-9.75 0-4.123 2.634-7.64 6.327-9.063a.75.75 0 01.94.93A7.501 7.501 0 0012 17.25c3.349 0 6.182-2.23 7.107-5.248a.75.75 0 01.645-.537z" />
                        </svg>
                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="white"
                            class="w-5 h-5"
                        >
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                </button>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
