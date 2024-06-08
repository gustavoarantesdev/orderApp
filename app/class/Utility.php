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
     * @param string $time The time to be formatted.
     * @param bool $withTime Whether or not to include the time in the formatting.
     * @return string The date formatted as a string.
     */

    public static function dateFormat(string $date, string $time, bool $withTime = false): string
    {
        $timestamp = strtotime($date);

        $formattedDate = date('d/m/Y', $timestamp);

        // Days of the week in Portuguese
        $daysOfWeek = [
            'Sun' => 'Dom',
            'Mon' => 'Seg',
            'Tue' => 'Ter',
            'Wed' => 'Qua',
            'Thu' => 'Qui',
            'Fri' => 'Sex',
            'Sat' => 'Sáb'
        ];

        $dayOfWeek = date('D', $timestamp);

        // Translate the day into Portuguese
        $dayOfWeekPt = $daysOfWeek[$dayOfWeek];

        // Add the day of the week next to the date.
        $formattedDateWithDay = $dayOfWeekPt . ' ' . $formattedDate;

        if ($withTime) {
            $formattedTime = date('H:i', strtotime($time));
            return $formattedDateWithDay . ' ' . $formattedTime;
        }

        return $formattedDateWithDay;
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

    /**
     * Converts the date to yyyy-mm-dd format to save in the database.
     *
     * Assumes that the input date is always in the format dd/mm/yyyy.
     *
     * @param string $completionDate The date to be converted.
     * @return string The converted date in yyyy-mm-dd format.
     */
    public static function dateSaveDb(string $completionDate): string
    {
        // Assumes that $completionDate is always in 'd/m/Y' format
        $date = DateTime::createFromFormat('d/m/Y', $completionDate);

        return $date->format('Y-m-d');
    }

    /**
     * Converts a string price by removing the ',' and replacing the ',' with '.' and converting to a float number to save in the database.
     *
     * @param string $price The price to convert.
     * @return float The price converted to float.
     */
    public static function orderPriceSaveDb(string $orderPrice): float
    {
        $normalized_price = str_replace(['.', ','], ['', '.'], $orderPrice);

        return (float) $normalized_price;
    }

    /**
     * Converts the number of installments to an integer, and if the payment method is different from credit, it is converted to blank.
     *
     * @param string $paymentMethod The payment method.
     * @param string $paymentInstallments The payment installments.
     * @return int|string The number of installments as an integer or an empty string if the method is not credit.o connect
     */
    public static function paymentInstallmentsSaveDb(string $paymentMethod, string $paymentInstallments)
    {
        $invalidInstallments = 'Selecione...';
        $nonCreditMethods = [
            'Cartão de Débito',
            'Dinheiro',
            'Pix'
        ];

        if ($paymentInstallments === $invalidInstallments || in_array($paymentMethod, $nonCreditMethods, true)) {
            return 0;
        }

        return (int) $paymentInstallments;
    }
}