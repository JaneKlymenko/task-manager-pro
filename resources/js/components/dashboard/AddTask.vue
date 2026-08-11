<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <Form
        method="post"
        :action="route('tasks.store')"
        class="flex flex-col gap-2 p-4"
        v-slot="{ errors, processing }"
        reset-on-success
        preserve-scroll
    >
        <div class="flex gap-2">
            <Input name="title" type="text" placeholder="Enter task..." class="flex-1" required maxlength="255" />
            <Button type="submit" :disabled="processing">Add</Button>
        </div>
        <InputError :message="errors.title" />
    </Form>
</template>
