<?php

class Utility
{
    public static function dateFormat($date)
    {
        return date('d/m/y H:i', strtotime($date));
    }
}