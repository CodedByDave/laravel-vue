import { ref, onMounted } from 'vue';

const theme = ref('light');

export function useTheme() {
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

    return { theme, toggleTheme };
}
