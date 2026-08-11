<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Task } from '@/types';
import { Head } from '@inertiajs/vue3';
import AddTask from '../components/dashboard/AddTask.vue';
import Tasks from '../components/dashboard/Tasks.vue';
import Timer from '../components/dashboard/Timer.vue';

defineProps<{
    tasks: Task[];
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-6">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 md:col-span-4 dark:border-sidebar-border">
                    <AddTask />
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 md:col-span-2 dark:border-sidebar-border">
                    <Timer />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <Tasks :tasks="tasks" />
            </div>
        </div>
    </AppLayout>
</template>
