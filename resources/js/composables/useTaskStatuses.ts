import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export type TaskStatusOption = {
    value: string;
    label: string;
};

export function useTaskStatuses() {
    const page = usePage();

    const statuses = computed(
        () => (page.props.taskStatuses as TaskStatusOption[] | undefined) ?? [],
    );

    const statusLabel = (status?: string | null) => {
        if (!status) {
            return statuses.value.find((item) => item.value === 'pending')?.label ?? 'Pending';
        }

        return statuses.value.find((item) => item.value === status)?.label ?? status;
    };

    const statusClass = (status?: string | null) => {
        switch (status) {
            case 'new':
                return 'bg-sky-100 text-sky-800 dark:bg-sky-900/40 dark:text-sky-300';
            case 'pending':
                return 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300';
            case 'in_progress':
                return 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300';
            case 'completed':
                return 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300';
            case 'cancelled':
                return 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300';
            default:
                return 'bg-muted text-muted-foreground';
        }
    };

    return {
        statuses,
        statusLabel,
        statusClass,
    };
}
