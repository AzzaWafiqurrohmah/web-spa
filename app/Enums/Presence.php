<?php

namespace App\Enums;

enum Presence: string
{
    case absent = "Izin";
    case half = "Setengah Hari";
    case full = "Hadir";
    case empty = "Belum Diisi";

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[$case->name] = $case->value;
        }
        return $values;
    }
}
