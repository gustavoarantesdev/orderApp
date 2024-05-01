<?php

/**
 * This class provides utility functions that are commonly used throughout the codebase.
 * 
 * @author gustavoarantes
 */
class Utility
{
    /**
     * This method format a date for display in Brazilian format, optionally incluing the time.
     * 
     * @param string $date The date to be formatted. 
     * @param bool $withTime A Boolean value to whether or not to include the time in the formatting.
     * @return string The date formatted as a string. 
     */
    public static function dateFormat($date, $withTime)
    {
        return ($withTime) ? date('d/m/y', strtotime($date)) : date('d/m/y H:i', strtotime($date));
    }

    /**
     * This method format the price for display, replacing the period with a comma. 
     * 
     * @param float $price The price to be formatted.
     * @return string The price formatted as a string. 
     */ 
    public static function priceFormat($price)
    {
        return str_replace('.', ',', $price);
    }
}