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

    /**
     * This method cut title bigger then 20 characters.
     * 
     * @param string $title The title to be cutted.
     * @return string The title cutted.
     */
    public static function cutTitle($title)
    {
        if (strlen($title) <= 20)
        {
            return $title;
        }
        else 
        {
            $cuttedTitle = substr($title, 0, 20) . '...';
            return $cuttedTitle;
        }
    }

    /**
     * This method cuts the customer's name when finding the first space in the name.
     * 
     * @param string $client The client name to be cutted.
     * @return string The client name cutted.
     */
    public static function formatClient($client)
    {
        $hasSpace = str_contains($client, ' ');
        return $hasSpace ? strstr($client, ' ', true) : $client;
    }

    /**
     * This method formats the payment type to an abbreviated version.
     * @param string $paymentMethod The payment method name to be cutted.
     * @return string The payment name formatted.
     */
    public static function formatPaymentMethod($paymentMethod)
    {
        if ($paymentMethod == 'Cartão de Crédito')
        {
            return 'Crédito';
        }
        else if ($paymentMethod == 'Cartão de Débito')
        {
            return 'Débito';
        }
        else
        {
            return $paymentMethod;
        }
    } 

    /**
     * This method formats the order status by adding a span in place of 1 or 0.
     * 
     * @param string $status The status value.
     * @return string The status formatted.
     */
    public static function formatFinishStatus($status)
    {
        if ($status == '1')
        {
            return '<span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">Finalizada <i class="bi bi-box2-heart-fill"></i></span>';
        }
        else
        {
            return '<span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">N.Finalizada <i class="bi bi-box2-fill"></i></span>';
        }
    }

    /**
     * This method calculates the difference in days between the given date and the current date.
     * It formats the output to indicate whether the date is overdue or how many days are left.
     * 
     * @param string $date The date to compare with the current date.
     * @return string The formatted difference in days.
     */
    public static function daysCount($date)
    {
        $databaseDate = new DateTime($date);
        $currentDate = new DateTime();

        $difference = $currentDate ->diff($databaseDate);

        if ($difference->invert) {
            return '<p class="card-text text-danger rounded-5"><strong>ATRASADA ' . $difference->days . ' DIAS!</strong></p>';
        } else {
            return 'FALTAM ' . $difference->days . ' DIAS.';
        }
    }
}