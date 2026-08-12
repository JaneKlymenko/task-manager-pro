<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Form } from '@inertiajs/vue3';

const fieldClass =
    'border-input bg-background text-foreground placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-ring/50 dark:bg-input/30 dark:[color-scheme:dark] flex w-full rounded-md border px-3 text-sm shadow-xs outline-none focus-visible:ring-[3px]';
</script>

<template>
    <Form
        method="post"
        :action="route('tasks.store')"
        class="p-4"
        v-slot="{ errors, processing }"
        reset-on-success
        preserve-scroll
    >
        <div class="grid gap-4 sm:grid-cols-2">
            <div class="space-y-2 sm:col-span-2">
                <Label for="title">Title</Label>
                <Input id="title" name="title" placeholder="What needs to be done?" required maxlength="255" />
                <InputError :message="errors.title" />
            </div>

            <div class="space-y-2 sm:col-span-2">
                <Label for="description">Description</Label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    placeholder="Optional details..."
                    :class="[fieldClass, 'py-2']"
                />
                <InputError :message="errors.description" />
            </div>

            <div class="space-y-2">
                <Label for="status">Status</Label>
                <select id="status" name="status" :class="[fieldClass, 'h-9']">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In progress</option>
                    <option value="done">Done</option>
                </select>
                <InputError :message="errors.status" />
            </div>

            <div class="space-y-2">
                <Label for="priority">Priority</Label>
                <select id="priority" name="priority" :class="[fieldClass, 'h-9']">
                    <option value="0">Low (0)</option>
                    <option value="1">Normal (1)</option>
                    <option value="2">High (2)</option>
                    <option value="3">Urgent (3)</option>
                </select>
                <InputError :message="errors.priority" />
            </div>

            <div class="space-y-2">
                <Label for="due_date">Due date</Label>
                <Input id="due_date" name="due_date" type="date" />
                <InputError :message="errors.due_date" />
            </div>

            <div class="space-y-2">
                <Label for="time_estimate">Time estimate (minutes)</Label>
                <Input id="time_estimate" name="time_estimate" type="number" min="1" placeholder="e.g. 30" />
                <InputError :message="errors.time_estimate" />
            </div>

            <div class="sm:col-span-2">
                <Button type="submit" :disabled="processing">Add task</Button>
            </div>
        </div>
    </Form>
</template>
