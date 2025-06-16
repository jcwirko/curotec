<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter
} from '@/components/ui/card'

// Obtenemos las props del servidor
const page = usePage()

// Accedemos a las tasks
const tasks = computed(() => page.props.tasks.data)

console.log('--------------')
console.log(tasks)
</script>

<template>
    <div class="p-6 space-y-4">
        <h1 class="text-2xl font-bold text-gray-800">📝 Lista de tareas</h1>

        <div v-if="tasks.length === 0" class="text-muted-foreground">
            No hay tareas disponibles.
        </div>

        <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <Card v-for="task in tasks" :key="task.id" class="transition-shadow hover:shadow-md">
                <CardHeader>
                    <CardTitle>{{ task.title }}</CardTitle>
                    <CardDescription>{{ task.description }}</CardDescription>
                </CardHeader>
                <CardContent class="flex justify-between items-center text-sm">
                    <span class="text-muted-foreground">Prioridad: {{ task.priority }}</span>
                    <span :class="task.is_completed
                        ? 'text-green-600 font-semibold'
                        : 'text-yellow-600 font-semibold'">
                        {{ task.is_completed ? 'Completada' : 'Pendiente' }}
                    </span>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
