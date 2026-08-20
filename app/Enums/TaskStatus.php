<?php

namespace App\Enums;

enum TaskStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return __('task.status.'.$this->value);
    }

    public function isFinal(): bool
    {
        return match ($this) {
            self::COMPLETED, self::CANCELLED => true,
            default => false,
        };
    }

    /** @return array<int, array{value: string, label: string}> */
    public static function options(): array
    {
        return array_map(
            fn (self $status) => [
                'value' => $status->value,
                'label' => $status->label(),
            ],
            self::cases(),
        );
    }
}
