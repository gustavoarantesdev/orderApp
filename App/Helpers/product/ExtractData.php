<?php

namespace App\Helpers\product;

/**
 * Classe abstrata para extrair os dados da superglobal $_POST.
 */
abstract class ExtractData
{
    /**
     * Extrai os dados do formulário de produto.
     * @param array $formProductData Dados do formulário.
     * @return object
     */
    public static function handle(array $formProductData): object
    {
        return (object) [
            'id'          => $formProductData['id'] ?? null ,
            'name'        => $formProductData['name'] ,
            'cost_price'  => $formProductData['cost_price'],
            'sell_price'  => $formProductData['sell_price'],
            'description' => !empty($formProductData['description']) ? $formProductData['description'] : null,
            'status'      => $formProductData['status'],
        ];
    }
}
