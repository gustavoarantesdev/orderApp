<?php

class Utility
{
    public static function dateFormat($date, $mode = 'null')
    {
         return ($mode == 'noTime') ? date('d/m/y', strtotime($date)) :  date('d/m/y H:i', strtotime($date));
    }

    public static function priceFormat($price)
    {
        return str_replace('.', ',', $price);
    }
}