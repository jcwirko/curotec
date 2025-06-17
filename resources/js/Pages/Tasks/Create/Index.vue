<script setup lang="ts">
import { ref } from 'vue'
import { createTask, updateTask } from '@/services/TaskService'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const taskId = route.params.id
const task = ref(null)
const errors = ref({})

const emit = defineEmits(['created', 'cancelled'])

const form = ref({
    title: '',
    description: '',
    priority: 'medium',
    is_completed: false,
})

const props = defineProps<{
    task?: {
        id: number
        title: string
        description: string | null
        priority: string
        is_completed: boolean
    } | null
}>()

function submit() {
    errors.value = {}

    const request = task.value
        ? updateTask(task.value.id, form.value)
        : createTask(form.value)

    request
        .then(response => {
            emit('created', response.data)
            if (!props.task) {
                router.push('/tasks')
            }
        })
        .catch(error => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors || {}
            }
        })
}

function cancel() {
    router.push('/tasks')
}
</script>

<template>
    <div class="flex justify-center items-start mt-10">
        <div class="w-full max-w-md p-6 border rounded shadow-md bg-white">
            <h2 class="text-xl font-semibold mb-4">
                {{ taskId ? 'Edit Task' : 'New Task' }}
            </h2>

            <form @submit.prevent="submit">
                <input v-model="form.title" placeholder="Title" class="w-full mb-2 p-2 border rounded" />
                <span class="text-red-600" v-if="errors?.title">{{ errors.title[0] }}</span>

                <textarea v-model="form.description" placeholder="Description"
                    class="w-full mb-2 p-2 border rounded"></textarea>

                <select v-model="form.priority" class="w-full mb-2 p-2 border rounded">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>

                <label class="flex items-center mb-4 space-x-2">
                    <input v-model="form.is_completed" type="checkbox" />
                    <span>Completed?</span>
                </label>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="cancel" class="px-3 py-1 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                        {{ taskId ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
