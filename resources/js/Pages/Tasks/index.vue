<template>
    <h1 class="text-4xl font-extrabold mb-6 text-gray-900 border-b pb-2">Filters</h1>

    <TaskFilters v-model:filters="filters" @clear="clearFilters" />

    <div class="flex justify-between items-center mb-6 border-b pb-2">
        <h1 class="text-4xl font-extrabold text-gray-900">
            Tasks List
        </h1>

        <RouterLink to="/tasks/create"
            class="px-3 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 transition text-sm">
            ➕ New Task
        </RouterLink>
    </div>

    <TaskList :tasks="tasks" :meta="meta" @deleted="onTaskDeleted" @changePage="onChangePage" />
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue'
import { getTasks } from '@/services/taskService'
import TaskFilters from '@/Pages/Tasks/Filters/Index.vue'
import TaskList from '@/Pages/Tasks/List/index.vue'
import { RouterLink } from 'vue-router'

const tasks = ref({ data: [] })
const meta = ref({})

const filters = ref({
    search: '',
    priority: '',
    is_completed: '',
    per_page: 10,
    page: 1
})

const fetchTasks = async () => {
    try {
        const response = await getTasks(filters.value)
        tasks.value = response.data
        meta.value = response.meta
    } catch (error) {
        console.error('Error fetching tasks:', error)
    }
}

onMounted(fetchTasks)
watch(filters, fetchTasks, { deep: true })

const clearFilters = () => {
    filters.value = {
        search: '',
        priority: '',
        is_completed: '',
        per_page: 10,
        page: 1
    }
}

function onTaskDeleted(id) {
    tasks.value = tasks.value.filter(task => task.id !== id);
}

const onChangePage = (page: number) => {
    filters.value.page = page
}
</script>
