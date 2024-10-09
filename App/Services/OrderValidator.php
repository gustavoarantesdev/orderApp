<?php

namespace App\Services;

use DateTime;

/**
 * Classe responsável por centralizar a validação dos dados da encomenda.
 */
abstract class OrderValidator
{
    /**
     * Extrai os dados do array recebidos via POST.
     *
     * @param array $postData Dados do formulário.
     * @return object
     */
    public static function extractData(array $postData): object
    {
        return (object) [
            'order_id'             => $postData['order_id'] ?? null,
            'order_title'          => $postData['order_title'],
            'client_name'          => $postData['client_name'],
            'completion_date'      => $postData['completion_date'],
            'completion_time'      => $postData['completion_time'],
            'order_price'          => $postData['order_price'],
            'payment_method'       => $postData['payment_method'],
            'payment_installments' => $postData['payment_installments'],
            'order_description'    => $postData['order_description'],
            'is_completed'         => $postData['is_completed'] ?? false,
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
     * Converte o número de parcelas para o valor inteiro, e se a forma
     * de pagamento for diferente de crédito retorna 0.
     *
     * @param string $paymentMethod
     * @param string $paymentInstallments
     * @return int
     */
    private static function paymentInstallmentsFormatSaveDb(string $paymentMethod, string $paymentInstallments): int
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

    /**
     * Converte o formatado da data de BR para o formato US.
     *
     * @param string $completionDate
     * @return string
     */
    private static function dateFormatSaveDb(string $completionDate): string
    {
        $orderDate = DateTime::createFromFormat('d/m/Y', $completionDate);

        return $orderDate->format('Y-m-d');
    }




    /**
     * Formata o status da encomenda.
     *
     * @param int $isCompleted
     * @param string $completionDate
     * @return string
     */
    private static function formatOrderStatusShow(int $isCompleted, string $completionDate): string
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
     * Calcula a diferença entre os dias da entrega com o dia atual.
     * E formata a saída indicando quantos dias que está atrasada.
     *
     * @param string $completionDate
     * @return string
     */
    private static function daysCountShow(string $completionDate): string
    {
        $completionDate = new DateTime($completionDate);
        $currentDate = new DateTime();
        $dateDifference = $currentDate->diff($completionDate);

        return $dateDifference->invert
            ? "<p class=\"card-text text-danger rounded-5\"><strong>ATRASADA $dateDifference->days DIAS!</strong></p>" 
            : "FALTAM $dateDifference->days DIAS.";
    }

    /**
     * Corta o título da encomenda se ele exceder 20 caracteres.
     *
     * @param string $orderTitle
     * @return string
     */
    private static function formatOrderTitleShow(string $orderTitle): string
    {
        return (strlen($orderTitle) <= 20) ? $orderTitle : substr($orderTitle, 0, 20) . '...';
    }

    /**
     * Corta o nome do cliente no primeiro espaço econtrado.
     *
     * @param string $clientName 
     * @return string
     */
    private static function formatClientNameShow(string $clientName): string
    {
        return strstr($clientName, ' ', true) ?: $clientName;
    }

    /**
     * Formata a data para exibição, convertendo do formato US para BR, podendo
     * ser com horas ou não.
     *
     * @param string $completionDate
     * @param string $completionTime
     * @param bool $withTime
     * @return string
     */
    private static function formatOrderDateShow(string $completionDate, string $completionTime, bool $withTime = false): string
    {
        $timestamp = strtotime($completionDate);

        $formattedDate = date('d/m/Y', $timestamp);

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
        $formattedDateWithDay = "$dayOfWeekPt $formattedDate";

        if ($withTime) {
            $formattedTime = date('H:i', strtotime($completionTime));
            return "$formattedDateWithDay $formattedTime";
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
     * Formata o tipo de pagamento abreviando.
     *
     * @param string $paymentMethod
     * @return string
     */
    private static function formatPaymentMethod(string $paymentMethod): string
    {
        return match ($paymentMethod) {
            'Cartão de Crédito' => 'Crédito',
            'Cartão de Débito' => 'Débito',
            default => $paymentMethod,
        };
    }

    /**
     * Prepara os dados da encomenda para armazenamento no banco de dados.
     *
     * @param object $orderData
     * @return object
     */
    public static function prepareOrderDataToSaveDb(object $orderData): object
    {
        $orderData->order_price = OrderValidator::priceFormatSaveDb($orderData->order_price);
        $orderData->payment_installments = OrderValidator::paymentInstallmentsFormatSaveDb($orderData->payment_method, $orderData->payment_installments);
        $orderData->completion_date = OrderValidator::dateFormatSaveDb($orderData->completion_date);

        return $orderData;
    }

    /**
     * Formata os dados da encomenda para exibição.
     *
     * @param object $orderData
     * @return object
     */
    public static function formatOrderDataToPrint(object $orderData): object
    {
        $orderData->order_status    = OrderValidator::formatOrderStatusShow($orderData->is_completed, $orderData->completion_date);
        $orderData->order_title     = OrderValidator::formatOrderTitleShow($orderData->order_title);
        $orderData->client_name     = OrderValidator::formatClientNameShow($orderData->client_name);
        $orderData->days_count      = OrderValidator::daysCountShow($orderData->completion_date);
        $orderData->completion_date = OrderValidator::formatOrderDateShow($orderData->completion_date, $orderData->completion_time, true);
        $orderData->order_price     = OrderValidator::formatOrderPrice($orderData->order_price);
        $orderData->payment_method  = OrderValidator::formatPaymentMethod($orderData->payment_method);
        $orderData->created_at      = OrderValidator::formatOrderDateShow($orderData->created_at, false);

        return $orderData;
    }
}
