<script setup lang="ts">
import AddTask from '@/components/dashboard/AddTask.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'My tasks', href: '/tasks' },
    { title: 'New task', href: '/tasks/create' },
];
</script>

<template>
    <Head title="New task" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full max-w-3xl p-4">
            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <AddTask />
            </div>
        </div>
    </AppLayout>
</template>
