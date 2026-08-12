<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem, type Task } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
    task: Task;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: props.task.title, href: route('tasks.show', props.task.id) },
];
</script>

<template>
    <Head :title="task.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto flex w-full max-w-3xl flex-1 flex-col gap-6 p-4">
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0 space-y-2">
                    <h1 class="text-2xl font-semibold tracking-tight break-words">{{ task.title }}</h1>
                    <p class="text-sm text-muted-foreground">
                        Status:
                        <span :class="task.is_done ? 'text-green-600' : 'text-amber-600'">
                            {{ task.is_done ? 'Done' : 'Open' }}
                        </span>
                    </p>
                </div>
                <Button as-child variant="outline">
                    <Link :href="route('dashboard')">Back</Link>
                </Button>
            </div>

            <div class="space-y-4 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <div>
                    <h2 class="mb-2 text-sm font-medium text-muted-foreground">Description</h2>
                    <p class="whitespace-pre-wrap">{{ task.description || 'No description yet.' }}</p>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-muted-foreground">Priority</dt>
                        <dd>{{ task.priority ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-muted-foreground">Status</dt>
                        <dd>{{ task.status ?? 'pending' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-muted-foreground">Due date</dt>
                        <dd>{{ task.due_date || '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-muted-foreground">Time estimate</dt>
                        <dd>{{ task.time_estimate ? `${task.time_estimate} min` : '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-muted-foreground">Created</dt>
                        <dd>{{ task.created_at ? new Date(task.created_at).toLocaleString() : '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </AppLayout>
</template>
