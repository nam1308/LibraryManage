<?php


use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date, string $format = 'Y/m/d')
    {
        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        return $date;
    }
}

if (!function_exists('randomString')){
    function randomString($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~`!@#$%^&*()-_+={}[]|\/:;".<>,.?';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}
