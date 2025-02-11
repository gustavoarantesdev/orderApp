<?php

namespace App\Helpers\order;

use App\Helpers\ConvertPrice;
use App\Helpers\order\fixPaymentInstallments;

/**fixPaymentInsta
 * Classe abstrata para extrair os dados da superglobal $_POST.
 */
abstract class ExtractData
{
    /**
     * Extrai os dados do formulário de encomenda, aplicando as conversões necessárias.
     * @param array $formOrderData Dados do formulário.
     * @return object
     */
    public static function handle(array $formOrderData): object
    {
        $products = [];

        // Percorre os produtos da encomenda
        foreach ($formOrderData as $key => $value) {
        // Verifique se a chave está no formato esperado (como 'product_id', 'product_name', etc.)
        if (strpos($key, 'product_id') === 0) {
            // Extrair o número do produto do nome da chave
            preg_match('/\d+/', $key, $matches);
            $i = $matches[0];

            // Adiciona o produto ao array
            $products[] = [
                'product_id'    => (int) $formOrderData["product_id$i"],
                'product_name'  => $formOrderData["product_name$i"],
                'sell_price'    => ConvertPrice::handle($formOrderData["product_sell_price$i"]),
                'quantity'      => (int) $formOrderData["product_quantity$i"],
            ];
        }
    }

        return (object) [
        'id'               => $formOrderData['id'] ?? null,
        'customer_id'      => (int) $formOrderData['customer_id'],
        'delivery_address' => $formOrderData['customer_address'],
        'products'         => $products, // Adiciona todos os itens em um array
        'additional'       => ConvertPrice::handle($formOrderData['additional']),
        'discount'         => ConvertPrice::handle( $formOrderData['discount']),
        'subtotal'         => ConvertPrice::handle($formOrderData['subtotal']),
        'payment_value'    => ConvertPrice::handle($formOrderData['payment_value']),
        'payment_status'   => (int) $formOrderData['payment_status'],
        'payment_method'   => (int) $formOrderData['payment_method'],
        'payment_installments' => fixPaymentInstallments::handle($formOrderData['payment_method'], $formOrderData['payment_installments']),
        'payment_date'     => $formOrderData['payment_date'],
        'completion_date'  => $formOrderData['completion_date'],
        'completion_time'  => $formOrderData['completion_time'],
        'withdraw'         => $formOrderData['withdraw'],
        'order_status'     => (int) $formOrderData['order_status'],
        'description'      => !empty($formOrderData['description']) ? $formOrderData['description'] : null,
    ];
    }
}
