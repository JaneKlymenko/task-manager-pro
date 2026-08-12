<script setup lang="ts">
import Tasks from '@/components/dashboard/Tasks.vue';
import Timer from '@/components/dashboard/Timer.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Task } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    tasks: Task[];
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-6">
                <div
                    class="relative flex items-center justify-between gap-4 overflow-hidden rounded-xl border border-sidebar-border/70 p-4 md:col-span-4 dark:border-sidebar-border"
                >
                    <div>
                        <h1 class="text-xl font-semibold">Dashboard</h1>
                        <p class="text-sm text-muted-foreground">Track time and jump into your tasks.</p>
                    </div>
                    <Button as-child>
                        <Link :href="route('tasks.create')">New task</Link>
                    </Button>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 md:col-span-2 dark:border-sidebar-border">
                    <Timer />
                </div>
            </div>
            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <Tasks :tasks="tasks" />
            </div>
        </div>
    </AppLayout>
</template>
