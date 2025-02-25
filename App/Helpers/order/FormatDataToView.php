<?php

namespace App\Helpers\order;

use App\Helpers\ConvertPrice;
use DateTime;

/**
 * Classe respnsável por centralizar os métodos para formatar os dados da encomenda
 * para a view.
 */
class FormatDataToView
{
    /**
     * Formata os dados da encomenda, com os outros métodos dessa classe.
     * @param object $ordersData Dados de todas as encomendas.
     */
    public static function handle(object $ordersData): object
    {
        foreach ($ordersData as $orderData) {
            $orderData->order_status    = self::formatOrderStatus($orderData->order_status, $orderData->completion_date);
            $orderData->customer_name   = self::formatCustomerName($orderData->customer_name);
            isset($orderData->withdraw) ? $orderData->withdraw = self::formatWithdraw($orderData->withdraw) : null;
            $orderData->completion_date = self::formatDate($orderData->completion_date);
            isset($orderData->completion_time) ? $orderData->completion_time = self::formatTime($orderData->completion_time) : null;
            $orderData->payment_method  = self::formatPaymentMethod($orderData->payment_method);
            $orderData->payment_value   = ConvertPrice::handle($orderData->payment_value, 'br');
            $orderData->subtotal        = ConvertPrice::handle($orderData->subtotal, 'br');
            $orderData->payment_status  = self::formatPaymentStatus($orderData->payment_status, $orderData->payment_value);
        }

        return $orderData;
    }

    /**
     * Formata o status da encomenda (se ela está em produção, atrasada, concluída)
     * de acordo com a data de finalização e status da encomenda.
     *
     * @param int $status Status da encomenda.
     * @param string $completionDate Data de entrega.
     * @return string
     */
    private static function formatOrderStatus(int $status, string $completionDate): string
    {
        $currentDate = date('Y-m-d');
        $daysCounted = self::daysCountShow((string) $completionDate);

        $orderStatus = [
            'production' => '<span class="badge bg-tertiary-subtle border border-tertiary-subtle text-body-secondary rounded-pill text-center py-2"><i class="bi bi-circle-fill me-1"></i>Faltam ' . $daysCounted . ' Dias</span>',
            'scheduled'  => '<span class="badge bg-info-subtle border border-info-subtle text-info-emphasis rounded-pill text-center py-2"><i class="bi bi-circle-fill me-1"></i>Agendada</span>',
            'today'      => '<span class="badge bg-warning-subtle border border-warning-subtle text-warning-emphasis rounded-pill text-center py-2"><i class="bi bi-circle-fill text-warning me-1"></i>Para Hoje!</span>',
            'tomorrow'   => '<span class="badge bg-primary-subtle border border-primary-subtle text-primary rounded-pill text-center py-2"><i class="bi bi-circle-fill me-1"></i>Para Amanhã</span>',
            'overdue'    => '<span class="badge bg-danger-subtle border border-danger-subtle text-danger rounded-pill text-center py-2"><i class="bi bi-circle-fill me-1"></i>Atrasada!</span>',
            'completed'  => '<span class="badge bg-success-subtle border border-success-subtle text-success rounded-pill text-center py-2"><i class="bi bi-circle-fill me-1"></i>Finalizada</span>',
        ];

        // Encomenda finalizada
        if ($status == 3) {
            return $orderStatus['completed'];
        }

        // Encomenda para o dia atual
        if ($completionDate == $currentDate) {
            return $orderStatus['today'];
        }

        // Encomenda para amanhã
        if ($daysCounted == 0) {
            return $orderStatus['tomorrow'];
        }

        // Encomenda atrasada
        if ($status == 2 && $completionDate < $currentDate) {
            return $orderStatus['overdue'];
        }

        // Encomenda em produção
        if ($status == 2) {
            return $orderStatus['production'];
        }

        // Encomenda agendada
        if ($status == 1) {
            return $orderStatus['scheduled'];
        }

        // Encomenda para os próximos dias
        return $orderStatus['production'];
    }

    /**
     * Formata o status de pagamento, de acordo com o status informado no cadastro da encomenda.
     *
     * @param int $status Status da encomenda.
     * @param string $paymentValue Valor do pagamento.
     * @return string
     */
    private static function formatPaymentStatus(int $status, string $paymentValue): string
    {
        // Não foi pago
        if ($status == 1) {
            return '<span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill text-center">Não foi Pago</span>';
        }

        // Foi pago
        if ($status == 2) {
            return '<span class="badge bg-success-subtle border border-success-subtle text-success rounded-pill text-center">Pago (R$ ' . $paymentValue . ')</span>';
        }

        // Pago parcialmente
        return '<span class="badge bg-primary-subtle border border-primary-subtle text-primary rounded-pill text-center mb-2">Pago Parcial (R$ ' . $paymentValue . ')</span>';
    }

    /**
     * Calcula a diferença entre a data de entrega com a data atual.
     *
     * @param string $date Data de entrega da encomenda.
     * @return string
     */
    private static function daysCountShow(string $date): string
    {
        $completionDate = new DateTime($date);
        $currentDate = new DateTime();
        $orderDateDifference = $currentDate->diff($completionDate);

        return $orderDateDifference->days;
    }

    /**
     * Reduz uma string se ele houver mais de 20 caracteres.
     *
     * @param string $str String a ser reduzida.
     * @return string
     */
    private static function reduceString(string $str): string
    {
        return (strlen($str) <= 20) ? $str : substr($str, 0, 20) . '...';
    }

    /**
     * Formata o nome do cliente para apresentar somente primeiro e último nome.
     * Se houver somente um nome e ele for maior que 20 caracteres limita.
     *
     * @param string $orderClientName
     * @return string
     */
    private static function formatCustomerName(string $name): string
    {
        $name = explode(' ', $name);

        if (count($name) > 1) {
            $firstName = reset($name);
            $lastName = end($name);
            return $name = "$firstName $lastName";
        }

        return self::reduceString($name[0]);
    }

    /**
     * Formata a data para o padrão pt-BR, com o dia da semana.
     *
     * @param string $date Data de entrega.
     * @return string
     */
    private static function formatDate(string $date): string
    {
        $timestamp = strtotime($date);

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
        $formattedDateWithDay = "$dayOfWeekPt $formattedDate";

        return $formattedDateWithDay;
    }

    /**
     * Formata a hora de entrega, para o padrão hora/minuto.
     * @param string $time
     * @return string
     */
    private static function formatTime(string $time): string
    {
        $time = date('H:i', strtotime($time));
        return $time;
    }

    /**
     * Formata se a encomenda tem retirada.
     *
     * @param bool $withdraw
     * @return string
     */
    private static function formatWithdraw(bool $withdraw): string
    {
        $formatedWithdraw = '<span class="badge bg-warning-subtle border border-warning-subtle text-warning-emphasis rounded-pill text-center">Retirada</span>';

        return $withdraw ? $formatedWithdraw : '';
    }

    /**
     * Formata a forma de pagamento.
     *
     * @param int $paymentMethod
     * @return string
     */
    private static function formatPaymentMethod(int $paymentMethod): string
    {
        return match ($paymentMethod) {
            1 => 'C. Crédito',
            2 => 'C. Débito',
            3 => 'Dinheiro',
            4 => 'PIX'
        };
    }

}
