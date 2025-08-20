<script setup lang="ts">
interface Task {
    id: number;
    title: string;
    done: boolean;
}

defineProps<{ tasks: Task[] }>();
const emit = defineEmits(['toggle-task', 'delete-task']);
</script>

<template>
    <ul class="divide-y">
        <li v-for="task in tasks" :key="task.id" class="flex items-center justify-between p-3">
            <label class="flex items-center gap-2">
                <input type="checkbox" :checked="task.done" @change="emit('toggle-task', task.id)" />
                <span :class="{ 'line-through': task.done }">{{ task.title }}</span>
            </label>
            <button @click="emit('delete-task', task.id)" class="text-red-500">✕</button>
        </li>
    </ul>
</template>
