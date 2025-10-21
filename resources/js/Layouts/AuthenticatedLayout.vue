<script setup>
import Sidebar from "@/Components/Sidebar.vue";
</script>

<template>
    <div class="flex bg-gray-950 min-h-screen text-gray-200">
        <Sidebar />

        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="h-14 border-b border-gray-800 flex items-center px-6 bg-gray-900">
                <h2 class="text-xl font-semibold">
                    <slot name="title" />
                </h2>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
