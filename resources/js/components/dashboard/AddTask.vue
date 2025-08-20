<script setup lang="ts">
import { ref } from 'vue';

const taskTitle = ref('');
const emit = defineEmits(['add-task']);

const addTask = () => {
    if (!taskTitle.value.trim()) return;
    emit('add-task', { id: Date.now(), title: taskTitle.value, done: false });
    taskTitle.value = '';
};
</script>

<template>
    <div class="flex gap-2 p-4">
        <input v-model="taskTitle" type="text" placeholder="Enter task..." class="flex-1 rounded-md border px-3 py-2" />
        <button @click="addTask" class="rounded-md bg-blue-600 px-4 py-2 text-white">Add</button>
    </div>
</template>
