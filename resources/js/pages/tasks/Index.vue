<script setup lang="ts">
import Tasks from '@/components/dashboard/Tasks.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Task } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    tasks: Task[];
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'My tasks', href: '/tasks' }];
</script>

<template>
    <Head title="My tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <Tasks :tasks="tasks" />
            </div>
        </div>
    </AppLayout>
</template>
