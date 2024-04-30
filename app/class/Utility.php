<?php

/**
 * This class is to centralize the auxiliary codes used in many parts of the code.
 * @author gustavoarantes
 */
class Utility
{
    /**
     * This method is used to convert dates to the Brazilian format dd/mm/yyyy h:s.
     * @param $date - Date is the database date..
     * @param $withTime - Receive boolean values, true when there is a timetable and false when the timetable is not needed.
     * @return - returns the formatted date. 
     */
    public static function dateFormat($date, $withTime)
    {
        return ($withTime) ? date('d/m/y', strtotime($date)) : date('d/m/y H:i', strtotime($date));
    }

    public static function priceFormat($price)
    {
        return str_replace('.', ',', $price);
    }
}