<template>
    <div class="grid md:grid-cols-4 gap-4 mb-10">
        <div class="flex flex-col">
            <label class="mb-1 font-semibold text-sm">Priority</label>
            <select :value="filters.priority" @change="updateFilter('priority', $event.target.value)"
                class="border p-2 rounded">
                <option value="">Todas las prioridades</option>
                <option value="high">Alta</option>
                <option value="medium">Media</option>
                <option value="low">Baja</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="mb-1 font-semibold text-sm">Status</label>
            <select :value="filters.is_completed" @change="updateFilter('is_completed', $event.target.value)"
                class="border p-2 rounded">
                <option value="">Todas</option>
                <option value="1">Completadas</option>
                <option value="0">Pendientes</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="mb-1 font-semibold text-sm">Items per page</label>
            <select :value="filters.per_page" @change="updateFilter('per_page', parseInt($event.target.value))"
                class="border p-2 rounded">
                <option :value="10">10</option>
                <option :value="25">25</option>
                <option :value="50">50</option>
            </select>
        </div>

        <button @click="clearFilters"
            class="self-end px-3 py-1 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700 transition">
            Clear filters
        </button>
    </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'

const props = defineProps<{
    filters: {
        search: string
        priority: string
        is_completed: string
        per_page: number
        page: number
    }
}>()

const emit = defineEmits(['update:filters', 'clear'])

const updateFilter = (key: keyof typeof props.filters, value: any) => {
    emit('update:filters', { ...props.filters, [key]: value })
}

const clearFilters = () => {
    emit('clear')
}
</script>
