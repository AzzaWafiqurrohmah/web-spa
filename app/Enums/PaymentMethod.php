<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case cash = "Cash";
    case transfer = "Transfer";

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[$case->name] = $case->value;
        }
        return $values;
    }
}
