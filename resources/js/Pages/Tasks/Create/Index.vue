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

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Categories</label>
                    <select v-model="form.category_ids" multiple class="w-full p-2 border rounded">
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <span class="text-red-600" v-if="errors?.category_ids">{{ errors.category_ids[0] }}</span>
                </div>

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

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { createTask, getTask, updateTask } from '@/services/TaskService'
import { useRoute, useRouter } from 'vue-router'
import { getCategories } from '@/Services/CategoryService'

const route = useRoute()
const router = useRouter()
const task = ref(null)
const taskId = route.params.id
const errors = ref({})
const isLoading = ref(false)

const form = ref({
    title: '',
    description: '',
    priority: 'medium',
    is_completed: false,
    category_ids: [],
})

const emit = defineEmits(['created', 'cancelled'])

const props = defineProps<{
    task?: {
        id: number
        title: string
        description: string | null
        priority: string
        is_completed: boolean
    } | null
}>()

const categories = ref<{ id: number; name: string }[]>([])

onMounted(async () => {
    try {
        categories.value = await getCategories()

        if (taskId) {
            isLoading.value = true
            const response = await getTask(taskId)
            form.value = {
                ...response.data.data,
                category_ids: response.data.data.categories?.map((c: any) => c.id) || []
            }
        }
    } catch (err) {
        error.value = 'Failed to load the task or categories'
        console.error(err)
    }
})

function submit() {
    errors.value = {}

    const request = taskId
        ? updateTask(taskId, form.value)
        : createTask(form.value)

    request
        .then(response => {
            emit('created', response.data)
            alert(`Task ${taskId ? 'updated' : 'created'} successfully`)
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
