<?php

namespace App\Helpers\product;

use App\Helpers\ConvertPrice;

/**
 * Formata os dados para exibir na view.
 */
abstract class FormatDataToShow
{
    public static function handle(object $data): object
    {
        // Percorre o array de objetos que é retornado da model, aplicando as funções.
        foreach ($data as $item) {
            $item->sell_price = ConvertPrice::handle($item->sell_price, 'br');
            $item->cost_price = ConvertPrice::handle($item->cost_price, 'br');

            $item->status = self::status($item->status);
        }

        return $data;
    }

    /**
     * Formata o status para Ativo ou Desativo.
     * @param bool $status Status armazenado no banco de dados.
     * @return string
     */
    private static function status(bool $status): string
    {
        if ($status == 1) {
            return $status = 'Ativo';
        }

        return $status = 'Desativo';
    }
}
