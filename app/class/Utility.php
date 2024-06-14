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
     * @param string $completionDate The order completion date to be formatted.
     * @param string $completionTime The order completion time to be formatted.
     * @param bool $withTime Whether or not to include the time in the formatting.
     * @return string The date formatted as a string.
     */

    public static function dateFormat(string $completionDate, string $completionTime, bool $withTime = false): string
    {
        $timestamp = strtotime($completionDate);

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
            $formattedTime = date('H:i', strtotime($completionTime));
            return $formattedDateWithDay . ' ' . $formattedTime;
        }

        return $formattedDateWithDay;
    }

    /**
     * Formats the price for display, replacing the period with a comma.
     * 
     * @param float $orderPrice The order price to be formatted.
     * @return string The price formatted as a string.
     */
    public static function priceFormat(float $orderPrice): string
    {
        return number_format($orderPrice, 2, ',', '.');
    }

    /**
     * Cuts the title if it is longer than 20 characters.
     * 
     * @param string $orderTitle The order title to be cut.
     * @return string The cut title.
     */
    public static function cutTitle(string $orderTitle): string
    {
        return (strlen($orderTitle) <= 20) ? $orderTitle : substr($orderTitle, 0, 20) . '...';
    }

    /**
     * Cuts the customer's name at the first space.
     * 
     * @param string $clientName The client name to be cut.
     * @return string The cut client name.
     */
    public static function formatClient(string $clientName): string
    {
        return strstr($clientName, ' ', true) ?: $clientName;
    }

    /**
     * Formats the payment type to an abbreviated version.
     * 
     * @param string $paymentMethod The order payment method name to be cut.
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
     * Formats the order status.
     * 
     * @param int $isCompleted The completed order status value.
     * @param string $completionDate The order completion date.
     * @return string The order status.
     */
    public static function orderStatus(int $isCompleted, string $completionDate): string
    {
        $status = [
            'completed' => '<span class="p-2 badge bg-success-subtle border border-success-subtle text-success-emphasis rounded-pill">FINALIZADA</span>',
            'overdue'   => '<span class="p-2 badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill">ATRASADA</span>',
            'open'      => '<span class="p-2 badge bg-warning-subtle border border-warning-subtle text-warning-emphasis rounded-pill">ABERTA</span>'
        ];

        if ($isCompleted == '1') {
            return $status['completed'];
        }

        $completionDate = new DateTime($completionDate);
        $currentDate = new DateTime();

        return $completionDate <= $currentDate
            ? $status['overdue']
            : $status['open'];
    }

    /**
     * Calculates the difference in days between the given date and the current date.
     * Formats the output to indicate whether the date is overdue or how many days are left.
     * 
     * @param string $completionDate The order completion date to compare with the current date.
     * @return string The formatted difference in days.
     */
    public static function daysCount(string $completionDate): string
    {
        $completionDate = new DateTime($completionDate);
        $currentDate = new DateTime();
        $dateDifference = $currentDate->diff($completionDate);

        return $dateDifference->invert 
            ? '<p class="card-text text-danger rounded-5"><strong>ATRASADA ' . $dateDifference->days . ' DIAS!</strong></p>' 
            : 'FALTAM ' . $dateDifference->days . ' DIAS.';
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
        $date = DateTime::createFromFormat('d/m/Y', $completionDate);

        return $date->format('Y-m-d');
    }

    /**
     * Converts a string price by removing the ',' and replacing the ',' with '.' and converting to a float number to save in the database.
     *
     * @param string $orderPrice The order price to be convert.
     * @return float The price converted in float.
     */
    public static function orderPriceSaveDb(string $orderPrice): float
    {
        $normalizedPrice = str_replace(['.', ','], ['', '.'], $orderPrice);

        return (float) $normalizedPrice;
    }

    /**
     * Converts the number of installments to an integer, and if the payment method is different from credit, it is converted to blank.
     *
     * @param string $paymentMethod The order payment method.
     * @param string $paymentInstallments The order payment installments.
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