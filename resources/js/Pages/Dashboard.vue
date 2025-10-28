<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Users, FileText, CheckCircle, Clock, Search, Filter } from 'lucide-vue-next';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalStudents: 245,
            totalQuizzes: 32,
            completedQuizzes: 156,
            pendingQuizzes: 89
        })
    },
    students: {
        type: Object,
        default: () => ({
            data: [
                { id: 1, student_number: '2024-001', name: 'John Doe', email: 'john@example.com', quizzesTaken: 12, averageScore: 85, lastActive: '2024-10-27' },
                { id: 2, student_number: '2024-002', name: 'Jane Smith', email: 'jane@example.com', quizzesTaken: 15, averageScore: 92, lastActive: '2024-10-28' },
                { id: 3, student_number: '2024-003', name: 'Mike Johnson', email: 'mike@example.com', quizzesTaken: 8, averageScore: 78, lastActive: '2024-10-26' },
                { id: 4, student_number: '2024-004', name: 'Sarah Williams', email: 'sarah@example.com', quizzesTaken: 20, averageScore: 95, lastActive: '2024-10-28' },
                { id: 5, student_number: '2024-005', name: 'David Brown', email: 'david@example.com', quizzesTaken: 10, averageScore: 88, lastActive: '2024-10-27' },
                { id: 6, student_number: '2024-006', name: 'Emily Davis', email: 'emily@example.com', quizzesTaken: 18, averageScore: 91, lastActive: '2024-10-29' },
                { id: 7, student_number: '2024-007', name: 'Chris Wilson', email: 'chris@example.com', quizzesTaken: 7, averageScore: 72, lastActive: '2024-10-25' },
                { id: 8, student_number: '2024-008', name: 'Amanda Lee', email: 'amanda@example.com', quizzesTaken: 14, averageScore: 89, lastActive: '2024-10-28' },
            ],
            current_page: 1,
            last_page: 3,
            per_page: 5,
            total: 20,
            links: [
                { url: null, label: '&laquo; Previous', active: false },
                { url: '#', label: '1', active: true },
                { url: '#', label: '2', active: false },
                { url: '#', label: '3', active: false },
                { url: '#', label: 'Next &raquo;', active: false }
            ]
        })
    }
});

// Reactive search and filter states
const searchQuery = ref('');
const scoreFilter = ref('all');
const quizzesFilter = ref('all');

// Filter options
const scoreOptions = [
    { value: 'all', label: 'All Scores' },
    { value: 'excellent', label: 'Excellent (90-100%)' },
    { value: 'good', label: 'Good (75-89%)' },
    { value: 'needs_improvement', label: 'Needs Improvement (<75%)' }
];

const quizzesOptions = [
    { value: 'all', label: 'All Quizzes' },
    { value: 'high', label: 'High (15+)' },
    { value: 'medium', label: 'Medium (8-14)' },
    { value: 'low', label: 'Low (<8)' }
];

// Computed property for filtered students
const filteredStudents = computed(() => {
    if (!props.students.data) return [];

    return props.students.data.filter(student => {
        // Search filter
        const matchesSearch = searchQuery.value === '' ||
            student.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            student.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            student.student_number.toLowerCase().includes(searchQuery.value.toLowerCase());

        // Score filter
        const matchesScore = scoreFilter.value === 'all' ||
            (scoreFilter.value === 'excellent' && student.averageScore >= 90) ||
            (scoreFilter.value === 'good' && student.averageScore >= 75 && student.averageScore < 90) ||
            (scoreFilter.value === 'needs_improvement' && student.averageScore < 75);

        // Quizzes filter
        const matchesQuizzes = quizzesFilter.value === 'all' ||
            (quizzesFilter.value === 'high' && student.quizzesTaken >= 15) ||
            (quizzesFilter.value === 'medium' && student.quizzesTaken >= 8 && student.quizzesTaken < 15) ||
            (quizzesFilter.value === 'low' && student.quizzesTaken < 8);

        return matchesSearch && matchesScore && matchesQuizzes;
    });
});

// Reset filters when search changes significantly
watch(searchQuery, (newQuery) => {
    if (newQuery.length > 2) {
        // Optional: You can add debouncing here for performance
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <div
                v-for="(card, index) in [
                    { title: 'Total Students', value: stats.totalStudents, color: 'blue', icon: Users },
                    { title: 'Total Quizzes', value: stats.totalQuizzes, color: 'purple', icon: FileText },
                    { title: 'Completed', value: stats.completedQuizzes, color: 'green', icon: CheckCircle },
                    { title: 'Pending', value: stats.pendingQuizzes, color: 'orange', icon: Clock }
                ]"
                :key="index"
                class="bg-white dark:bg-gray-900 rounded-lg shadow p-5 md:p-6 border border-gray-200 dark:border-gray-800 transition-colors duration-300"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">{{ card.title }}</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ card.value }}</p>
                    </div>
                    <div :class="`bg-${card.color}-100 dark:bg-${card.color}-900/30 p-3 rounded-lg`">
                        <component :is="card.icon" :class="`w-7 h-7 sm:w-8 sm:h-8 text-${card.color}-600 dark:text-${card.color}-400`" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow border border-gray-200 dark:border-gray-800 transition-colors duration-300">

            <!-- Table Header with Search and Filters -->
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Recent Students</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ filteredStudents.length }} students</span>
                    </div>

                    <!-- Search Bar -->
                    <div class="relative flex-1 sm:max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <Search class="h-4 w-4 text-gray-400" />
                        </div>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search students by name, email, or student number..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>

                <!-- Filters -->
                <div class="mt-4 flex flex-col sm:flex-row gap-4">
                    <!-- Score Filter -->
                    <div class="flex items-center gap-2">
                        <Filter class="h-4 w-4 text-gray-400" />
                        <select
                            v-model="scoreFilter"
                            class="border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option v-for="option in scoreOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                    </div>

                    <!-- Quizzes Filter -->
                    <div class="flex items-center gap-2">
                        <Filter class="h-4 w-4 text-gray-400" />
                        <select
                            v-model="quizzesFilter"
                            class="border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option v-for="option in quizzesOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                    </div>

                    <!-- Clear Filters -->
                    <button
                        @click="searchQuery = ''; scoreFilter = 'all'; quizzesFilter = 'all';"
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 underline"
                    >
                        Clear filters
                    </button>
                </div>
            </div>

            <!-- Scrollable Table on Mobile -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm sm:text-base">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Student Number</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Student</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase hidden md:table-cell">Email</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase hidden sm:table-cell">Quizzes</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase hidden sm:table-cell">Avg Score</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase hidden lg:table-cell">Last Active</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        <tr
                            v-for="student in filteredStudents"
                            :key="student.id"
                            class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"
                        >
                            <!-- Student Number -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white font-mono text-sm">
                                {{ student.student_number }}
                            </td>

                            <!-- Student Info -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="bg-gray-300 dark:bg-gray-700 w-9 h-9 rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                        {{ student.name[0].toUpperCase() }}
                                    </div>
                                    <div>
                                        <p class="text-gray-900 dark:text-white font-medium">{{ student.name }}</p>
                                        <!-- Show email inline on mobile -->
                                        <p class="text-gray-500 dark:text-gray-400 text-xs md:hidden">{{ student.email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 hidden md:table-cell">
                                {{ student.email }}
                            </td>

                            <!-- Quizzes Taken -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white hidden sm:table-cell">
                                {{ student.quizzesTaken }}
                            </td>

                            <!-- Average Score -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full"
                                    :class="student.averageScore >= 90
                                        ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400'
                                        : student.averageScore >= 75
                                        ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400'
                                        : 'bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400'"
                                >
                                    {{ student.averageScore }}%
                                </span>
                            </td>

                            <!-- Last Active -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 hidden lg:table-cell">
                                {{ student.lastActive }}
                            </td>

                            <!-- Actions -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm">
                                <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                    View
                                </button>
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="filteredStudents.length === 0">
                            <td colspan="7" class="px-4 sm:px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <Search class="h-12 w-12 text-gray-300 dark:text-gray-600 mb-2" />
                                    <p class="text-lg font-medium text-gray-900 dark:text-white mb-1">No students found</p>
                                    <p class="text-sm">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Pagination Info -->
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing
                        <span class="font-medium">{{ (students.current_page - 1) * students.per_page + 1 }}</span>
                        to
                        <span class="font-medium">{{ Math.min(students.current_page * students.per_page, students.total) }}</span>
                        of
                        <span class="font-medium">{{ students.total }}</span>
                        results
                    </div>

                    <!-- Pagination Links -->
                    <div class="flex items-center space-x-1">
                        <!-- Previous Button -->
                        <button
                            :disabled="students.current_page === 1"
                            :class="[
                                'px-3 py-1 rounded-lg text-sm font-medium transition-colors',
                                students.current_page === 1
                                    ? 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                            ]"
                        >
                            Previous
                        </button>

                        <!-- Page Numbers -->
                        <template v-for="(link, index) in students.links" :key="index">
                            <button
                                v-if="link.label && !link.label.includes('Previous') && !link.label.includes('Next')"
                                :class="[
                                    'px-3 py-1 rounded-lg text-sm font-medium transition-colors',
                                    link.active
                                        ? 'bg-blue-600 text-white'
                                        : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                                ]"
                            >
                                {{ link.label }}
                            </button>
                        </template>

                        <!-- Next Button -->
                        <button
                            :disabled="students.current_page === students.last_page"
                            :class="[
                                'px-3 py-1 rounded-lg text-sm font-medium transition-colors',
                                students.current_page === students.last_page
                                    ? 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                            ]"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
