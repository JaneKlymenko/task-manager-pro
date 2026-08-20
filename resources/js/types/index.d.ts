import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    locale: string;
    taskStatuses: { value: string; label: string }[];
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type TaskStatus = 'new' | 'in_progress' | 'pending' | 'completed' | 'cancelled';

export interface Task {
    id: number;
    title: string;
    is_done: boolean;
    status?: TaskStatus | string;
    priority?: number;
    due_date?: string | null;
    description?: string | null;
    time_estimate?: number | null;
    time_spent?: number | null;
    created_at?: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
