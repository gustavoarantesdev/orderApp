<?php

class Utility
{
    public static function dateFormat($date, $mode = 'null')
    {
         return ($mode == 'noTime') ? date('d/m/y', strtotime($date)) :  date('d/m/y H:i', strtotime($date));
    }
}