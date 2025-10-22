<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template>
            <Layout>
                <template #title>Dashboard</template>

                <div class="grid grid-cols-3 gap-4">
                    <div
                        class="border border-gray-800 bg-gray-900 rounded-xl h-40"
                    ></div>
                    <div
                        class="border border-gray-800 bg-gray-900 rounded-xl h-40"
                    ></div>
                    <div
                        class="border border-gray-800 bg-gray-900 rounded-xl h-40"
                    ></div>
                    <div
                        class="border border-gray-800 bg-gray-900 rounded-xl h-40 col-span-3 h-60"
                    ></div>
                </div>
            </Layout>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h5 class="text-3xl font-bold">
                            Welcome back! {{ $page.props.auth.user.name }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
