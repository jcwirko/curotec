<template>
    <div v-if="tasks.length === 0" class="text-muted-foreground">
        No tasks available
    </div>

    <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <Card v-for="task in tasks" :key="task.id" class="transition-shadow hover:shadow-md relative">
            <CardHeader>
                <CardTitle>{{ task.title }}</CardTitle>
                <CardDescription>{{ task.description ?? 'Sin descripción' }}</CardDescription>

                <div v-if="task.categories?.length" class="flex flex-wrap gap-1 mt-2">
                    <span v-for="category in task.categories" :key="category.id"
                        class="px-2 py-0.5 bg-gray-100 text-xs text-gray-700 rounded-full">
                        {{ category.name }}
                    </span>
                </div>
            </CardHeader>

            <CardContent class="flex justify-between items-center text-sm">
                <span class="text-muted-foreground">Prioridad: {{ task.priority }}</span>
                <span :class="task.is_completed ? 'text-green-600 font-semibold' : 'text-yellow-600 font-semibold'">
                    {{ task.is_completed ? 'Completada' : 'Pendiente' }}
                </span>
            </CardContent>

            <div class="absolute top-2 right-2 flex gap-2">
                <router-link :to="`/tasks/${task.id}/edit`" title="Editar" class="text-blue-600 hover:text-blue-800">
                    <PencilIcon class="w-5 h-5" />
                </router-link>

                <button @click="openDeleteModal(task)" title="Eliminar" class="text-red-600 hover:text-red-800">
                    <TrashIcon class="w-5 h-5" />
                </button>
            </div>
        </Card>
    </div>

    <Pagination :items-per-page="meta.per_page" :total="meta.total" :default-page="meta.current_page">
        <PaginationContent>
            <PaginationPrevious :disabled="meta.current_page <= 1" @click="emit('changePage', meta.current_page - 1)" />

            <template v-for="i in meta.last_page" :key="i">
                <PaginationItem @click="emit('changePage', i)" :value="i" :is-active="i === meta.current_page">
                    {{ i }}
                </PaginationItem>
            </template>

            <PaginationNext :disabled="meta.current_page >= meta.last_page"
                @click="emit('changePage', meta.current_page + 1)" />
        </PaginationContent>
    </Pagination>

    <DeleteModal v-if="showDeleteModal" :key="taskToDelete?.id" :isVisible="showDeleteModal" :task="taskToDelete"
        @update:isVisible="showDeleteModal = $event" @confirmed="confirmDelete" />
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { defineProps, defineEmits } from 'vue'
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent
} from '@/components/ui/card'
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from '@/components/ui/pagination'
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'
import DeleteModal from '../Modals/DeleteModal.vue'
import { deleteTask } from '@/services/taskService'

const { tasks, meta } = defineProps<{
    tasks: { data: any[] },
    meta: any
}>()

const emit = defineEmits(['updated', 'deleted', 'changePage'])

const showDeleteModal = ref(false)
const taskToDelete = ref(null)

function openDeleteModal(task) {
    taskToDelete.value = task
    showDeleteModal.value = true
}

function closeDeleteModal() {
    showDeleteModal.value = false
    taskToDelete.value = null
}

async function confirmDelete() {
    try {
        const taskId = taskToDelete.value.id
        await deleteTask(taskId);
        closeDeleteModal();
        emit('deleted', taskId);
        alert('Task deleted successfully');
    } catch (error) {
        alert('Failed to delete task');
        console.error(error);
    }
}
</script>
