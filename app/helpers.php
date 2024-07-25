<?php

if (!function_exists('format_id')) {
    function format_id($position, $raw_id, $gender, $id)
    {
        $val = 1;
        if ($gender == 'female') $val = 2;

        $positionVal = 1;
        if ($position == 'customer') $positionVal = 2;

        return sprintf('%s.%s.%s.%s', $raw_id, $positionVal, $val, $id);
    }
}

if (!function_exists('format_member')) {
    function format_member($id)
    {
        return str_replace('.', '', $id);
    }
}

if (!function_exists('format_date')) {
    function format_date($date)
    {
        $date = \Illuminate\Support\Carbon::createFromFormat("Y-m-d", $date);
        return $date->format('d F Y');
    }
}

if (!function_exists('format_reservation')) {
    function format_reservation($date)
    {
        $date = \Illuminate\Support\Carbon::createFromFormat("Y-m-d", $date);
        return $date->format('Ymd');
    }
}


if (!function_exists('parseDateParam')) {
    function parseDateParam(?string $date)
    {
        if (is_null($date)) return null;

        $exploded = explode('-', $date);
        return (object) [
            'year' => $exploded[0],
            'month' => $exploded[1],
            'day' => $exploded[2] ?? null,
        ];
    }
}

if (!function_exists('genderID')) {
    function genderID(?string $gender)
    {
        if ($gender == 'male')


            $exploded = explode('-', $date);
        return (object) [
            'year' => $exploded[0],
            'month' => $exploded[1],
            'day' => $exploded[2] ?? null,
        ];
    }
}

if (!function_exists('rsv_date')) {
    function rsv_date(?\Carbon\Carbon $date)
    {
        if ($date == null) {
            return null;
        }

        \Carbon\Carbon::setLocale('id');
        $res = \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y');

        return $res;
    }
}

if (!function_exists('months')) {
    function months()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }
}
