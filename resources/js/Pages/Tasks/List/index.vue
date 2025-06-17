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
import TaskForm from '@/Pages/Tasks/Create/Index.vue'
import { PencilIcon, TrashIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const props = defineProps<{
    tasks: Array<{
        id: number
        title: string
        description: string | null
        priority: string
        is_completed: boolean
    }>
}>()

const emit = defineEmits(['updated', 'deleted'])

const showDeleteModal = ref(false)

const taskToEdit = ref(null)
const taskToDelete = ref(null)

function openDeleteModal(task) {
    taskToDelete.value = task
    showDeleteModal.value = true
}

function closeDeleteModal() {
    showDeleteModal.value = false
    taskToDelete.value = null
}

function confirmDelete() {
    emit('deleted', taskToDelete.value.id)
    closeDeleteModal()
}

</script>

<template>
    <div v-if="tasks.length === 0" class="text-muted-foreground">
        No tasks available
    </div>

    <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <Card v-for="task in tasks" :key="task.id" class="transition-shadow hover:shadow-md relative">
            <CardHeader>
                <CardTitle>{{ task.title }}</CardTitle>
                <CardDescription>{{ task.description ?? 'Sin descripción' }}</CardDescription>
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

    <!-- Modal eliminar -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-xs text-center">
            <h3 class="text-lg font-semibold mb-4">¿Desea eliminar esta tarea?</h3>
            <p class="mb-6">{{ taskToDelete?.title }}</p>
            <div class="flex justify-center gap-4">
                <button @click="closeDeleteModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button @click="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</template>
