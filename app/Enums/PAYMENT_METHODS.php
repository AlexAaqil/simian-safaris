<?php

namespace App\Enums;

enum PAYMENT_METHODS: int
{
    case KCBMPESAEXPRESS = 0;
    case STRIPE = 1;
    case PAYPAL = 2;

    public function label(): string
    {
        return match($this) {
            self::KCBMPESAEXPRESS => 'KCB M-PESA Express',
            self::STRIPE => 'Stripe',
            self::PAYPAL => 'PayPal',
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
