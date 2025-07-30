<?php

namespace App\Enums;

enum PAYMENT_STATUSES: int
{
    case PENDING = 0;
    case PAID = 1;
    case FAILED = 2;

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::PAID => 'Paid',
            self::FAILED => 'Failed',
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
