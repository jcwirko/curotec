<template>
    <div v-if="isVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-xs text-center">
            <h3 class="text-lg font-semibold mb-4">Remove this task?</h3>
            <p class="mb-6">{{ task?.title }}</p>
            <div class="flex justify-center gap-4">
                <button @click="cancel" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button @click="confirm" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, defineEmits, defineProps } from 'vue';

const props = defineProps<{
    isVisible: boolean;
    task: { id: number; title: string };
}>();

const emit = defineEmits(['update:isVisible', 'confirmed']);

const task = ref(props.task);

function cancel() {
    emit('update:isVisible', false);
}

function confirm() {
    console.log('AAAAAA')
    if (props.task) {
        emit('confirmed', props.task.id);
    }
    emit('update:isVisible', false);
}
</script>
