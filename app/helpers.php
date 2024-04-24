<?php

if (!function_exists('format_id'))
{
    function format_id($position ,$raw_id, $gender, $id) {
        $val = 1;
        if($gender == 'female') $val = 2;

        $positionVal = 1;
        if($position == 'customer') $positionVal = 2;

        return sprintf('%s.%s.%s.%s', $raw_id, $positionVal,$val, $id);
    }
}

if(!function_exists('format_member'))
{
    function format_member($id)
    {
        return str_replace('.', '', $id);
    }
}
