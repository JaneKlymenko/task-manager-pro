<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { useTaskStatuses } from '@/composables/useTaskStatuses';
import { type Task } from '@/types';
import { Link, router } from '@inertiajs/vue3';

defineProps<{ tasks: Task[] }>();

const { statusLabel, statusClass } = useTaskStatuses();

const toggleTask = (task: Task) => {
    router.patch(
        route('tasks.update', task.id),
        { is_done: !task.is_done },
        { preserveScroll: true },
    );
};

const deleteTask = (task: Task) => {
    router.delete(route('tasks.destroy', task.id), {
        preserveScroll: true,
    });
};

const formatDueDate = (dueDate?: string | null) => {
    if (!dueDate) return null;
    return new Date(dueDate).toLocaleDateString();
};
</script>

<template>
    <ul v-if="tasks.length" class="divide-y">
        <li v-for="task in tasks" :key="task.id" class="flex items-center justify-between gap-3 p-3">
            <div class="flex min-w-0 flex-1 items-center gap-3">
                <Checkbox :checked="task.is_done" @update:checked="toggleTask(task)" />
                <div class="min-w-0 flex-1">
                    <div class="flex min-w-0 items-center gap-2">
                        <Link
                            :href="route('tasks.show', task.id)"
                            class="truncate hover:underline"
                            :class="{ 'text-muted-foreground line-through': task.is_done }"
                        >
                            {{ task.title }}
                        </Link>
                        <span
                            class="shrink-0 rounded-md px-1.5 py-0.5 text-xs font-medium"
                            :class="statusClass(task.status)"
                        >
                            {{ statusLabel(task.status) }}
                        </span>
                    </div>
                    <p v-if="task.due_date || task.time_estimate" class="mt-0.5 truncate text-xs text-muted-foreground">
                        <span v-if="task.due_date">Due {{ formatDueDate(task.due_date) }}</span>
                        <span v-if="task.due_date && task.time_estimate"> · </span>
                        <span v-if="task.time_estimate">{{ task.time_estimate }} min</span>
                    </p>
                </div>
            </div>
            <Button type="button" variant="ghost" size="icon" class="text-destructive shrink-0" @click="deleteTask(task)">
                ✕
            </Button>
        </li>
    </ul>
    <p v-else class="p-6 text-center text-sm text-muted-foreground">No tasks yet. Add your first one above.</p>
</template>
