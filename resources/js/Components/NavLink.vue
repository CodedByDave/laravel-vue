<script setup>
import { computed, ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const theme = ref('light');

onMounted(() => {
    theme.value = localStorage.theme || 'light';
    applyTheme();
});

const toggleTheme = () => {
    theme.value = theme.value === 'light' ? 'dark' : 'light';
    localStorage.theme = theme.value;
    applyTheme();
};

const applyTheme = () => {
    const root = document.documentElement;
    if (theme.value === 'dark') {
        root.classList.add('dark');
    } else {
        root.classList.remove('dark');
    }
};

const props = defineProps({
    href: { type: String, required: true },
    active: { type: Boolean },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>

</template>
