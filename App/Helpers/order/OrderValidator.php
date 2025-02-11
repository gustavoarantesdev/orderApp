<?php

namespace App\Helpers\order;

use DateTime;

/**
 * Classe responsável por centralizar a validação dos dados da encomenda.
 */
abstract class OrderValidator
{
    /**
     * Extrai os dados do array recebidos via POST.
     *self
     * @param array $formData Dados do formulário.
     * @return object
     */
    public static function extractData(array $formData): object
    {
        return (object) [
            'order_id'                   => $formData['order_id'] ?? null,
            'order_title'                => $formData['order_title'],
            'order_quantity'             => $formData['order_quantity'],
            'order_client_name'          => $formData['order_client_name'],
            'order_withdraw'             => $formData['order_withdraw'],
            'order_completion_date'      => $formData['order_completion_date'],
            'order_completion_time'      => $formData['order_completion_time'],
            'order_delivery_address'     => $formData['order_delivery_address'],
            'order_price'                => $formData['order_price'],
            'order_payment_method'       => $formData['order_payment_method'],
            'order_payment_installments' => $formData['order_payment_installments'],
            'order_description'          => $formData['order_description'],
            'order_completed'            => $formData['order_completed'] ?? false,
        ];
    }

    /**
     * Converte o preço do formato BR para o formato US.
     *
     * @param string $price
     * @return float
     */
    private static function priceFormatSaveDb(string $price): float
    {
        return (float) $price = str_replace(['.', ','], ['', '.'], $price);
    }

    /**
     * Converte o número de parcelas para 0 se a forma de pagamento for diferente
     * de Cartão de Crédito.
     *
     * @param string $orderPaymentMethod
     * @param string $orderPaymentInstallments
     * @return int
     */
    private static function paymentInstallmentsFormatSaveDb(string $orderPaymentMethod, string $orderPaymentInstallments): int
    {
        return $orderPaymentMethod != 1 ? 1 : $orderPaymentInstallments;
    }

    /**
     * Prepara os dados da encomenda para armazenamento no banco de dados.
     *
     * @param object $orderData
     * @return object
     */
    public static function prepareOrderDataToSaveDb(object $orderData): object
    {
        $orderData->order_price = self::priceFormatSaveDb($orderData->order_price);
        $orderData->order_payment_installments = self::paymentInstallmentsFormatSaveDb($orderData->order_payment_method, $orderData->order_payment_installments);

        return $orderData;
    }




    /**
     * Formata o status da encomenda.
     *
     * @param int $isCompleted
     * @param string $completionDate
     * @return string
     */
    private static function formatOrderStatusShow(int $orderCompleted, string $orderCompletionDate): string
    {
        $currentDate = date('Y-m-d');
        $daysCounted = self::daysCountShow((string) $orderCompletionDate);

        $orderStatus = [
            'completed' => '<div class="bg-success-subtle text-success border border-success-subtle rounded-5 text-center py-2" style="width: 7rem; height: 2.rem;"><span><strong>Finalizada</strong></span></div>',
            'overdue'   => '<div class="bg-danger-subtle text-danger border border-danger-subtle rounded-5 text-center py-2" style="width: 7rem; height: 2.rem;"><span><strong>Atrasada!</strong></span></div>',
            'today'     => '<div class="bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-5 text-center py-2" style="width: 7rem; height: 2.rem;"><span><strong>Hoje!</strong></span></div>',
            'tomorrow'  => '<div class="bg-primary-subtle text-primary border border-primary-subtle rounded-5 text-center py-2" style="width: 7rem; height: 2.rem;"><span><strong>Amanhã</strong></span></div>',
            'open'      => '<div class="bg-body-tertiary text-body-secondary border border-tertiary-subtle rounded-5 text-center py-2" style="width: 7rem; height: 2.rem;"><strong>' . $daysCounted . ' Dias</strong></span></div>',
        ];

        if ($orderCompleted == 1) {
            return $orderStatus['completed'];
        }

        if ($orderCompletionDate == $currentDate) {
            return $orderStatus['today'];
        }

        if ( $daysCounted == '0') {
            return $orderStatus['tomorrow'];
        }

        if ($orderCompletionDate < $currentDate) {
            return $orderStatus['overdue'];
        }

        return $orderStatus['open'];
    }

    /**
     * Calcula a diferença entre a data de entrega com a data atual.
     *
     * @param string $orderCompletionDate
     * @return string
     */
    private static function daysCountShow(string $orderCompletionDate): string
    {
        $orderCompletionDate = new DateTime($orderCompletionDate);
        $currentDate = new DateTime();
        $orderDateDifference = $currentDate->diff($orderCompletionDate);

        return $orderDateDifference->days;
    }

    /**
     * Corta uma string se ele houver mais de 20 caracteres.
     * @param string $name
     * @return string
     */
    private static function cutName(string $name): string
    {
        return (strlen($name) <= 20) ? $name : substr($name, 0, 20) . '...';
    }

    /**
     * Formata título da encomenda limitando em 20 caracteres.
     *
     * @param string $orderTitle
     * @return string
     */
    private static function formatOrderTitleShow(string $orderTitle): string
    {
        return self::cutName($orderTitle);
    }

    /**
     * Formata o nome do cliente para apresentar somente primeiro e último nome.
     * Se houver somente um nome e ele for maior que 20 caracteres limita.
     *
     * @param string $orderClientName
     * @return string
     */
    private static function formatClientNameShow(string $orderClientName): string
    {
        $orderClientName = explode(' ', $orderClientName);

        if (count($orderClientName) > 1) {
            $firstName = reset($orderClientName);
            $lastName = end($orderClientName);
            return $orderClientName = "$firstName $lastName";
        }

        return self::cutName($orderClientName[0]);
    }

    /**
     * Formata a data para exibição, convertendo do formato US para BR, podendo
     * ser com horas ou não.
     *
     * @param string $orderDate
     * @param string $orderTime
     * @param bool $withTime
     * @return string
     */
    public static function formatOrderDateShow(string $orderDate, string $orderTime, bool $withTime = false): string
    {
        $timestamp = strtotime($orderDate);

        $formattedDate = date('d/m/y', $timestamp);

        // Dias da semana em pt-br 
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

        // Traduz os dias da semana para pt-br.
        $dayOfWeekPt = $daysOfWeek[$dayOfWeek];

        // Adiciona o dia da semana na data.
        $formattedDateWithDay = "$dayOfWeekPt - $formattedDate";

        if ($withTime) {
            $formattedTime = date('H:i', strtotime($orderTime));
            return "$formattedDateWithDay - $formattedTime";
        }

        return $formattedDateWithDay;
    }

    /**
     * Formata o preço para o formato BR.
     *
     * @param float $orderPrice
     * @return string
     */
    private static function formatOrderPrice(float $orderPrice): string
    {
        return number_format($orderPrice, 2, ',', '.');
    }

    /**
     * Formata se a encomenda tem retirada colocando Retirada no lugar do true.
     *
     * @param string $orderWithdraw
     * @return string
     */
    private static function formatOrderWithdraw(string $orderWithdraw): string
    {
        return $orderWithdraw ? ' - Retirada' : '';
    }

    /**
     * Formata a forma de pagamento.
     *
     * @param int $orderPaymentMethod
     * @return string
     */
    private static function formatPaymentMethod(int $orderPaymentMethod)
    {
        return match ($orderPaymentMethod) {
            1 => 'C. Crédito',
            2 => 'C. Débito',
            3 => 'Dinheiro',
            4 => 'PIX'
        };
    }

    /**
     * Formata os dados da encomenda para exibição.
     *
     * @param object $orderData
     * @return object
     */
    public static function formatOrderDataToPrint(object $orderData): object
    {
        $orderData->order_status          = self::formatOrderStatusShow($orderData->order_completed, $orderData->order_completion_date);
        $orderData->order_title           = self::formatOrderTitleShow($orderData->order_title);
        $orderData->order_client_name     = self::formatClientNameShow($orderData->order_client_name);
        $orderData->order_withdraw        = self::formatOrderWithdraw($orderData->order_withdraw);
        $orderData->order_completion_date = self::formatOrderDateShow($orderData->order_completion_date, $orderData->order_completion_time, true);
        $orderData->order_payment_method  = self::formatPaymentMethod($orderData->order_payment_method);
        $orderData->order_price           = self::formatOrderPrice($orderData->order_price);

        return $orderData;
    }
}
