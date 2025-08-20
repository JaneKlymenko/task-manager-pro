<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AddTask from '../components/dashboard/AddTask.vue';
import Tasks from '../components/dashboard/Tasks.vue';
import Timer from '../components/dashboard/Timer.vue';

interface Task {
    id: number;
    title: string;
    done: boolean;
}

const tasks = ref<Task[]>([]);

const addTask = (task: Task) => {
    tasks.value.push(task);
};

const toggleTask = (id: number) => {
    const t = tasks.value.find((t) => t.id === id);
    if (t) t.done = !t.done;
};

const deleteTask = (id: number) => {
    tasks.value = tasks.value.filter((t) => t.id !== id);
};

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-6">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 md:col-span-4 dark:border-sidebar-border">
                    <AddTask @add-task="addTask" />
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 md:col-span-2 dark:border-sidebar-border">
                    <Timer />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <Tasks :tasks="tasks" @toggle-task="toggleTask" @delete-task="deleteTask" />
            </div>
        </div>
    </AppLayout>
</template>
