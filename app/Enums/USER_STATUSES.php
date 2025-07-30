<?php

namespace App\Enums;

enum USER_STATUSES: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BANNED = 2;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'Inactive',
            self::ACTIVE => 'Active',
            self::BANNED => 'Banned',
        };
    }

    public static function labels(): array
    {
        $labels = [];

        foreach (self::cases() as $status) {
            $labels[$status->value] = $status->label();
        }

        return $labels;
    }
}
