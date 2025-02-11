<?php

namespace App\Helpers\Order;

/**
 * Ajusta a quantidade de parcelas para pagamentos, sempre que o pagamento for 
 * diferente de cartão de crédito, a quantidade de parcelas será alterado para 1.
 */
abstract class fixPaymentInstallments
{
    public static function handle(int $paymentMethod, string $paymentInstallments)
    {
        return $paymentMethod != 1 ? 1 : $paymentInstallments;
    }
}
