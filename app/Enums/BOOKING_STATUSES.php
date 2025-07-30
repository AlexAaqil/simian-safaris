<?php

namespace App\Enums;

enum BOOKING_STATUSES: int
{
    case PENDING = 0;
    case CONFIRMED = 1;
    case CANCELLED = 2;
    case COMPLETED = 3;

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CANCELLED => 'Cancelled',
            self::COMPLETED => 'Completed',
        };
    }

    public static function labels(): array
    {
        $labels = [];

        foreach(self::cases() as $status) {
            $labels[$status->value] = $status->label();
        }

        return $labels;
    }
}
