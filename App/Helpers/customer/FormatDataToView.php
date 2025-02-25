<?php

namespace App\Helpers\customer;

use App\Helpers\ConvertPrice;
use App\Helpers\FormatCustomerName;
use DateTime;

/**
 * Helper responsável por formata os dados para exibir na view.
 */
abstract class FormatDataToView
{
    public static function handle(object $data): object
    {
        // Percorre o array de objetos que é retornado da model, aplicando as funções.
        foreach ($data as $item) {
            $item->name        = FormatCustomerName::handle($item->name);
            $item->total_sales = ConvertPrice::handle($item->total_sales, 'br');
            $item->total_paid  = ConvertPrice::handle($item->total_paid, 'br');
            $item->gender      = $item->gender ??= '-';
            $item->yearsold    = self::calcYearsold($item->birth_date);
        }

        return $data;
    }

    /**
     * Calcula a idade do cliente.
     *
     * @param string|null $date Data de aniversário.
     * @return string
     */
    private static function calcYearsold(string|null $date): string
    {
        if ($date === null) {
            return '--';
        }

        $birthDate   = new DateTime($date);
        $currentDate = new DateTime();
        $yearsold    = $currentDate->diff($birthDate);

        return (string) $yearsold->y; // Idade do cliente
    }
}