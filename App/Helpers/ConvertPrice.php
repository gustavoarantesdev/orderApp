<?php

namespace App\Helpers;

/**
 * Classe responsável por converte o formato do preço.
 */
abstract class ConvertPrice
{
    /**
     * Converte o preço para o formato en_US (USD) ou pt_BR (BRL).
     * @param string $price Preço.
     * @param string $currency Tipo da moeda.
     * @return float|string
     */
    public static function handle(string $price, string $currency = 'us'): float|string
    {
        // Convete o preço para o formato pt_BR (BRL), para apresentar na view.
        if ($currency == 'br') {
            return number_format($price, 2, ',', '.');
        }

        // Converte o preço para o formato en_US (USD), para armazenar no banco de dados.
        return (float) $price = str_replace(['.', ','], ['', '.'], $price);
    }
}
