<?php

/**
 * This class provides utility functions that are commonly used throughout the codebase.
 * 
 * @author gustavoarantes
 */
class Utility
{
    /**
     * Formats a date for display in Brazilian format, optionally including the time.
     * 
     * @param string $date The date to be formatted.
     * @param bool $withTime Whether or not to include the time in the formatting.
     * @return string The date formatted as a string.
     */
    public static function dateFormat(string $date, bool $withTime = false): string
    {
        return $withTime ? date('d/m/Y H:i', strtotime($date)) : date('d/m/Y', strtotime($date));
    }

    /**
     * Formats the price for display, replacing the period with a comma.
     * 
     * @param float $price The price to be formatted.
     * @return string The price formatted as a string.
     */
    public static function priceFormat(float $price): string
    {
        return number_format($price, 2, ',', '.');
    }

    /**
     * Cuts the title if it is longer than 20 characters.
     * 
     * @param string $title The title to be cut.
     * @return string The cut title.
     */
    public static function cutTitle(string $title): string
    {
        return (strlen($title) <= 20) ? $title : substr($title, 0, 20) . '...';
    }

    /**
     * Cuts the customer's name at the first space.
     * 
     * @param string $client The client name to be cut.
     * @return string The cut client name.
     */
    public static function formatClient(string $client): string
    {
        return strstr($client, ' ', true) ?: $client;
    }

    /**
     * Formats the payment type to an abbreviated version.
     * 
     * @param string $paymentMethod The payment method name to be cut.
     * @return string The payment name formatted.
     */
    public static function formatPaymentMethod(string $paymentMethod): string
    {
        switch ($paymentMethod) {
            case 'Cartão de Crédito':
                return 'Crédito';
            case 'Cartão de Débito':
                return 'Débito';
            default:
                return $paymentMethod;
        }
    }

    /**
     * Formats the order status by adding a span in place of 1 or 0.
     * 
     * @param string $status The status value.
     * @return string The status formatted.
     */
    public static function formatFinishStatus(string $status): string
    {
        return ($status === '1') 
            ? '<span class="badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">Finalizada <i class="bi bi-box2-heart-fill"></i></span>' 
            : '<span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">N.Finalizada <i class="bi bi-box2-fill"></i></span>';
    }

    /**
     * Calculates the difference in days between the given date and the current date.
     * Formats the output to indicate whether the date is overdue or how many days are left.
     * 
     * @param string $date The date to compare with the current date.
     * @return string The formatted difference in days.
     */
    public static function daysCount(string $date): string
    {
        $databaseDate = new DateTime($date);
        $currentDate = new DateTime();
        $difference = $currentDate->diff($databaseDate);

        return $difference->invert 
            ? '<p class="card-text text-danger rounded-5"><strong>ATRASADA ' . $difference->days . ' DIAS!</strong></p>' 
            : 'FALTAM ' . $difference->days . ' DIAS.';
    }
}