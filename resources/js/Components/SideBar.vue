<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    Home,
    Github,
    BookText,
    ChevronLeft,
    ChevronRight,
    ChevronDown,
    Settings,
    LogOut
} from "lucide-vue-next";

const sidebarOpen = ref(true);
const dropdownOpen = ref(false);
</script>

<template>
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="bg-gray-900 text-white h-screen flex flex-col transition-all duration-300 border-r border-gray-700"
    >
        <!-- Sidebar Header -->
        <div
            class="flex items-center justify-between h-16 px-4 border-b border-gray-800"
        >
            <h1 v-if="sidebarOpen" class="text-lg font-bold text-center">
                Dashboard
            </h1>
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="text-gray-400 hover:text-white"
            >
                <component
                    :is="sidebarOpen ? ChevronLeft : ChevronRight"
                    class="w-5 h-5"
                />
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-3 mt-4 space-y-2">
            <Link
                :href="route('dashboard')"
                class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800"
                :class="
                    route().current('dashboard')
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-300'
                "
            >
                <Home class="w-5 h-5" />
                <span v-if="sidebarOpen">Dashboard</span>
            </Link>
        </nav>

        <!-- USER DROPDOWN -->
        <div class="mt-auto border-t border-gray-800">
            <div
                @click="dropdownOpen = !dropdownOpen"
                class="flex items-center gap-3 px-4 py-4 cursor-pointer hover:bg-gray-800 transition"
            >
                <div
                    class="bg-gray-700 w-8 h-8 rounded-full flex items-center justify-center text-sm"
                >
                    {{ $page.props.auth.user.name[0].toUpperCase() }}
                </div>

                <div class="flex-1 text-left">
                    <p class="text-sm font-medium">
                        {{ $page.props.auth.user.name }}
                    </p>
                    <p class="text-xs text-gray-400 truncate">
                        {{ $page.props.auth.user.email }}
                    </p>
                </div>

                <ChevronDown class="w-4 h-4" />
            </div>

            <!-- DROPDOWN LINKS -->
            <div v-if="dropdownOpen" class="px-4 pb-4 space-y-2">
                <Link
                    :href="route('profile.edit')"
                    class="flex items-center gap-2 text-sm text-gray-300 hover:text-white"
                >
                    <Settings class="w-4 h-4" />
                    <span>Settings</span>
                </Link>
                <Link
                    method="post"
                    as="button"
                    :href="route('logout')"
                    class="flex items-center gap-2 text-sm text-gray-300 hover:text-white"
                >
                    <LogOut class="w-4 h-4" />
                    <span>Log out</span>
                </Link>
            </div>
        </div>
    </aside>
</template>
