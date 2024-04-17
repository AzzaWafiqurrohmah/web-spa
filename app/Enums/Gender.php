<?php

namespace App\Enums;

enum Gender: string
{
    case male = "Laki - Laki";
    case female = "Perempuan";

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[$case->name] = $case->value;
        }
        return $values;
    }
}
